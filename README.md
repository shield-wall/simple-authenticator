Simple authenticator
====================

It's a simple symfony authenticator, for you be able to log in just with email.

### Install

```shell
composer req shield-w4ll/simple-authenticator
```

> **Note**
> We relly recommend use this package in **dev environment** only.

### Configuration

```yaml
#config/packages/shield_w4ll.yaml
when@dev:
  simple_authenticator:
    route:
      redirect_success: 'profile_edit'
      redirect_failure: 'app_login'

  security:
    firewalls:
      main:
        custom_authenticators:
          - ShieldWall\SimpleAuthenticator\Security\EmailAuthenticator
```

```yaml
#config/routes/shield_w4ll.yaml
simple_authenticator_login:
  prefix: ^/
  path: /simple_authenticator/login
```
```yaml
#config/service.yaml
ShieldWall\SimpleAuthenticator\Security\EmailAuthenticator:
        arguments:
            - '@Symfony\Component\Routing\Generator\UrlGeneratorInterface'
            - '@App\Repository\UserRepository'
            - '%shield_w4ll.simple_authenticator.route.redirect_success%'
            - '%shield_w4ll.simple_authenticator.route.redirect_failure%'
```
```php
//YourController.php
public function yourAction()
{
        $simpleAuthenticatorForm = $this->createForm(SimpleAuthenticatorType::class, null, [
            'action' => $this->generateUrl('simple_authenticator_login'),
        ]);
        $simpleAuthenticatorFromView = $simpleAuthenticatorForm->createView();

        return $this->render('your_template.html.twig', [
            'simpleAuthenticatorFrom' => $simpleAuthenticatorFromView,
        ]);
}

//your_file.html.twig
{{ form(simpleAuthenticatorFrom) }}
```

Repository
```php
//src/Repository/UserRepository.php
class UserRepository extends ServiceEntityRepository implements EmailRepositoryInterface
{
    public function findOneByEmail(string $email): UserInterface
    {
        return $this->findOneBy(['email' => $email]);
    }
}

```

TODO
- need to see someway to get the route name from controller `simple_authenticator_login`
- import route as resource
- service should be declared automatically.
