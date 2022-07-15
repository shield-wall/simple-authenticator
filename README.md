Simple authenticator
====================

It's a simple symfony authenticator, for you be able to log in just with email.

### Install

```shell
composer req --dev shield-w4all/simple-authenticator
```

> **Note**
> We relly recommend use this package in **dev environment** only.

### Configuration

```yaml
when@dev:
    shield_w4ll:
      simple_authenticator:
        route:
          redirect_success: 'app_user_area_example'
          redirect_failure: 'app_login_example'
  
```

Security
```yaml
#config/packages/security.yaml
when@dev:
    security:
      firewalls:
        main:
          custom_authenticators:
            - ShieldW4ll\SimpleAuthenticator\Security\EmailAuthenticator
```

Form
```php
public function yourAction()
{
        $simpleAuthenticatorForm = $this->createForm(SimpleAuthenticatorType::class, null, [
            'action' => $this->generateUrl('app_login_simple'),
        ]);
        $simpleAuthenticatorFromView = $simpleAuthenticatorForm->createView();

        return $this->render('your_template.html.twig', [
            'simpleAuthenticatorFrom' => $simpleAuthenticatorFromView,
        ]);
}


```