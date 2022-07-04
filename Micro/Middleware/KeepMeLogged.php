<?php


namespace API\Middleware;


use API\Core\Session\Session;
use API\Core\Utils\AppCrypt;
use API\Core\Utils\Logger;
use API\Models\AppUser;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class KeepMeLogged implements \Psr\Http\Server\MiddlewareInterface
{
    private $conn;

    /**
     * @inheritDoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
//        return $handler->handle($request);
        if (Session::get('loggedIn')) {
            return $handler->handle($request);
        }
        if (!isset($request->getCookieParams()['micro'])) {
            return $handler->handle($request);
        }

        $cookie = $request->getCookieParams()['micro'];
        list($identifier, $token) = explode(':', $cookie);

        Logger::log("middleware: FOUND COOKIE MICRO");
        $user = new AppUser();
        $user->setIdentifier($identifier)
            ->setToken($token);

        if ($user = $this->conn->validateAuthCookie($user)) {
            $this->conn->validate($user);
            $user->setId(Session::loggedUserID());
            $user->setToken(AppCrypt::generateToken());
            $user->setTimeout(time() + 60 * 60 * 24 * 7);
            $user = $this->conn->updateUserToken($user);
            setcookie('micro', "{$user->getIdentifier()}:{$user->getToken()}", time() + 60 * 60 * 24 * 7);
            $this->conn->updateLastLogged($user->getId());
            $this->setFlashCookie([
                'type' => 'success',
                'title' => 'Logged',
                'message' => 'Your login was made by KeepMeLogged Cookie ',
            ]);

            return (new Response())
                ->withStatus(200)
                ->withHeader('Location', APP_ASSET_BASE);
        }
        return $handler->handle($request);
    }

    public function setFlashCookie($cookie)
    {
        $appCookie = json_encode([
            'type' => $cookie['type'],
            'title' => rawurlencode($cookie['title']),
            'message' => rawurlencode($cookie['message']),
        ]);
        setcookie(
            'microFlash',
            "{$appCookie}",
            time() + 3,
            '/'
        );

    }

}