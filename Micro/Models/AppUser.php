<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 24/11/2018
 * Time: 13:11
 */

namespace API\Models;

use API\Core\Container\MicroDI;
use DateTime;
use API\Core\Utils\Translate;

class AppUser
{
    private $id;
    private $name;
    private $email;
    private $about;

    private $lastLogged;
    private $loggedTimeLine;

    private $created;
    private $edited;
    private $pass;
    private $avatar;
    private $rp_token;
    private $secret;
    private $language_active;
    private $identifier;
    private $id_pass;
    private $timeout;
    private $token;
    private $timeLine;
    private $lastEdited;

    public function __construct()
    {
        $args = func_get_args();
        $numArgs = func_num_args();

        if ($numArgs == 0) {
            $this->id = (int)$this->id;
            $this->name = (string)$this->name;
            $this->email = (string)$this->email;
            $this->created = (int)$this->created;
            $this->edited = (int)$this->edited;
            $this->pass = (string)$this->pass;
            $this->rp_token = (string)$this->rp_token;
            $this->secret = (string)$this->secret;
            $this->avatar = (string)$this->avatar;
            $this->language_active =(string)$this->language_active;
            $this->identifier = (string)$this->identifier;
            $this->id_pass = (string)$this->id_pass;
            $this->timeout = (string)$this->timeout;
            $this->token = (string)$this->token;
            $this->token = (string)$this->token;

            $this->timeLine = (string) AppUser::setTimeFromCreate();
            $this->lastEdited = (string) AppUser::setTimeFromEdit();
            $this->lastLogged = (string) AppUser::setTimeFromLastLogged();

        } else {
            call_user_func_array([$this,'__construct1'], $args);
        }
    }
    public function __construct1()
    {
        $args = func_get_args();
        $this->id = (int)$args[0];
        $this->name = (string)$args[1];
        $this->email = (string)$args[2];
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getRpToken(): string
    {
        return $this->rp_token;
    }
    public function getSecret(): string
    {
        return $this->secret;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getCreated(): string
    {
        return $this->created;
    }
    public function getEdited(): string
    {
        return $this->edited;
    }
    public function getPass(): string
    {
        return $this->pass;
    }
    public function getAvatar(): string
    {
        return APP_ASSET_BASE.'users'.DIRECTORY_SEPARATOR.'user_'.$this->id.DIRECTORY_SEPARATOR.$this->avatar;
    }
    public function getRawAvatar(): string
    {
        return $this->avatar;
    }
    public function getPrivateAvatar(): string
    {
        return $this->avatar;
    }
    public function getLanguageActive(): string
    {
        return $this->language_active;
    }
    public function getIdentifier(): string
    {
        return $this->identifier;
    }
    public function getIdPass(): string
    {
        return $this->id_pass;
    }
    public function getToken(): string
    {
        return $this->token;
    }
    public function getTimeout(): string
    {
        return $this->timeout;
    }
    public function getLastLogged()
    {
        return $this->lastLogged;
    }
    public function isLogged() : bool
    {
        return $this->id!==0;
    }
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }
    public function getAbout()
    {
        return $this->about;
    }
    public function setTimeout(string $timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }
    public function setRpToken(string $rp_token)
    {
        $this->rp_token = $rp_token;
        return $this;
    }
    public function setSecret(string $secret)
    {
        $this->secret = $secret;
        return $this;
    }
    public function setName(string $name): AppUser
    {
        $this->name = $name;
        return $this;
    }
    public function setEmail(string $email): AppUser
    {
        $this->email = $email;
        return $this;
    }
    public function setCreated(int $created): AppUser
    {
        $this->created = $created;
        return $this;
    }
    public function setEdited(int $edited): AppUser
    {
        $this->edited = $edited;
        return $this;
    }
    public function setPass(string $pass): AppUser
    {
        $this->pass = $pass;
        return $this;
    }
    public function setAvatar(string $avatar): AppUser
    {
        $this->avatar = $avatar;
        return $this;
    }
    public function setLanguageActive(string $language_active): AppUser
    {
        $this->language_active = $language_active;
        return $this;
    }
    public function setIdentifier(string $identifier): AppUser
    {
        $this->identifier = $identifier;
        return $this;
    }
    public function setIdPass(string $id_pass): AppUser
    {
        $this->id_pass = $id_pass;
        return $this;
    }
    public function setToken(string $token): AppUser
    {
        $this->token = $token;
        return $this;
    }
    private function setTimeFromCreate()
    {
        $diff = AppUser::dateDiff(
            $this->getCreated(),
            time()
        );
        $this->timeLine = $diff;
        return $this->timeLine;
    }
    private function setTimeFromLastLogged()
    {
        $diff = AppUser::dateDiff(
            $this->getLastLogged(),
            time()
        );
        $this->loggedTimeLine = $diff;
        return $this->loggedTimeLine;
    }
    private function setTimeFromEdit()
    {
        $diff = AppUser::dateDiff(
            $this->getEdited(),
            time()
        );
        $this->lastEdited = $diff;
        return $this->lastEdited;
    }

    public function getTimeFromCreate() :string {
//        return $this->created;
        if($this->timeLine===''){
            return "Seconds Ago...";
        }
        return $this->timeLine;
    }
    public function getTimeFromEdit() :string {
        if($this->lastEdited===''){
            return "Seconds Ago...";
        }
        return $this->lastEdited;
    }
    public function getTimeFromLastLogged() :string {
        if($this->loggedTimeLine===''){
            return "Seconds Ago...";
        }
        return $this->loggedTimeLine;
    }
    function dateDiff($start, $end)
    {
        // Checks $start and $end format (timestamp only for more simplicity and portability)
        $d_start = null;
        $d_end = null;

        if ($end == 0) {
            return 'NaN';
        }
        $start  = date('Y-m-d H:i:s', $start);
        $end    = date('Y-m-d H:i:s', $end);
        try {
            $d_start = new DateTime($start);
        } catch (\Exception $e) {
        }
        try {
            $d_end = new DateTime($end);
        } catch (\Exception $e) {
        }
        $diff = $d_start->diff($d_end);


        $year     = (int) $diff->format('%y');
        $month    = (int) $diff->format('%m');
        $day      = (int) $diff->format('%d');
        $hour     = (int) $diff->format('%h');
        $min      = (int) $diff->format('%i');
        $sec      = (int) $diff->format('%s');


        $bootstrap = require_once(realpath('../').
            DIRECTORY_SEPARATOR . PSR4_FOLDER.
            DIRECTORY_SEPARATOR . 'Config'.
            DIRECTORY_SEPARATOR . 'bootstrap.php' );

        $ioc = MicroDI::getInstance([]);

        /**@var $tra Translate */
        $tra = $ioc->get(Translate::class);

        $dateDif =[
            0 => [
                'label' => $year>1?$tra->translate('YEARS'):$tra->translate('YEAR'),
                'value' => $year,
            ],
            1 => [
                'label' => $month>1?$tra->translate('MONTHS'):$tra->translate('MONTH'),
                'value' => $month,
            ],
            2 => [
                'label' => $day>1?$tra->translate('DAYS'):$tra->translate('DAY'),
                'value' => $day,
            ],
            3 => [
                'label' => $hour>1?$tra->translate('HOURS'):$tra->translate('HOUR'),
                'value' => $hour,
            ],
            4 => [
                'label' => $min>1?$tra->translate('MINUTES'):$tra->translate('MINUTE'),
                'value' => $min,
            ],
            5 => [
                'label' => $sec>1?$tra->translate('SECONDS'):$tra->translate('SECOND'),
                'value' => $sec,
            ],
        ];
        $timeLapse = '';
        foreach ($dateDif as $key => $data) {
            if ($data['value'] != '0') {
                if ($key == 5) {
                    if ($timeLapse != '') {
                        $timeLapse .= 'e ' .$data['value'] .' '. $data['label'] . ' ';
                    } else {
                        $timeLapse .= $data['value'] .' '. $data['label'] . ' ';
                    }
                } else {
                    $timeLapse .= $data['value'] .' '. $data['label'] . ' ';
                }
            }
        }
        return $timeLapse;
    }
    public function setAbout($about)
    {
        $this->about = $about;
    }
    public function setTimeLineLastLogged($time )
    {
        $diff = AppUser::dateDiff(
            $time ,
            time()
        );
        $this->lastLogged = $diff;
        return $this;
    }
    public function setLastLogged($time )
    {
        $this->lastLogged = $time;
        return $this;
    }
}
