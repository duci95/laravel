<?php
namespace App\Http\Controllers;
use App\Http\Requests\LogRequest;
use App\Http\Requests\RegRequest;
use App\Models\Izvestaj;
use App\Models\Korisnik;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Psy\Util\Json;
class LogRegController extends Controller
{    /**
     * LogRegController constructor.
     */
    private $user;
    private $date;
    public function __construct()
    {
        $this->user = new Korisnik();
        $this->date = date('d.m.Y H:i');
    }
    public function login(LogRequest $request){
        $this->user->setUsername($request->input("username"));
        $this->user->setPassword($request->input("password"));

        try {
            $us = $this->user->login();
            if($us != null) {
                $request->session()->put("user", $us);
                $model = new Izvestaj();
                $model->setDatum($this->date);
                $model->setIDKorisnik(session()->get('user')->ID_korisnik);
                $model->insert("Korisnik se ulogovao");
                return  response(null,200);
            }
            else
                return response(null,401);
        }
        catch(QueryException $sql){
            Log::critical("Greska u radu sa bazom pri logovanju korisnika");
            return response(null, 500);
        }
    }
    public function register(RegRequest $request) {

        $this->user->setIme($request->input('firstname'));
        $this->user->setPrezime($request->input('lastname'));
        $this->user->setDatumRegistracije(date("d.m.Y"));
        $token = md5(time());
        $this->user->setToken($token);
        $this->user->setUsername($request->input("username"));
        $this->user->setPassword($request->input("password"));
        $this->user->setPol($request->input("gender"));
        $this->user->setIDGrad($request->input("city"));
        $email = $request->input("email");
        $this->user->setEmail($email);


            $mail = new PHPMailer(true);
        try {
            $this->user->register();
            //Server settings
            //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

            $mail->SMTPAuth = true;
            $mail->SMTPSecure = true;
            // Enable SMTP authentication
            $mail->Username = 'phpmailer1995@gmail.com';                 // SMTP username
            $mail->Password = 'dusan1995';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                 // TCP port to connect to

            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            //Recipients
            $mail->setFrom('phpmailer1995@gmail.com', 'Registracija');
            $mail->addAddress($email);     // Add a recipient

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Aktivirajte nalog';

            $mail->Body = 'Klinkite na <a href="http://127.0.0.1:8000/activation/' . $token . '" >link</a> da aktivirate profil';

            $mail->send();

            return response(null, 201);
        }

        catch(QueryException $exception){
            Log::error($exception->getMessage());
            return response(null,409);
        }
        catch (Exception $e) {
            Log::critical('Greska pri slanju mejla za registraciju');
            return response(null, 500);
        }
    }

    public function activation($param) {

        $this->user->setToken($param);
        try{
            $this->user->activate();
            return redirect('/prijava');
        }
        catch(QueryException $sql){
            Log::critical("Greska pri aktivaciji korisnika sa tokenom $param");
            return redirect()->back();
        }
    }

    public function logout(Request $request){
        $model = new Izvestaj();
        $model->setIDKorisnik(session()->get('user')->ID_korisnik);
        $model->setDatum($this->date);
        try{
            $model->insert("Korisnik se izlogovao");
        }
        catch (QueryException $sql){
            Log::error('Greska pri ubacivanju u tabelu izvestaj');
        }
        $request->session()->forget("user");
        $request->flush();
        return redirect(route("renderLogin"));
    }

}
