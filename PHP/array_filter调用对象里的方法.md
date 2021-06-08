```php
 function(){
 $value = "12@qq.com;232@qq.com";
  $emails  = preg_replace('/\s/', '', $value);
                    $emails      = explode(';', rtrim($emails, ';'));
                    $verifyEmail = array_filter($emails, [$this,'filterEmail']
                        , ARRAY_FILTER_USE_BOTH);
                    if (count($verifyEmail) !== count($emails)) {
                        return false;
                    }
                    return true;
 }  
                    
 function filterEmail($email): bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        ## Yii2
            $this->addError('notify_email', sprintf('邮箱[%s]格式不正确.', $email));

            return false;
        }

        return true;
    }
```
