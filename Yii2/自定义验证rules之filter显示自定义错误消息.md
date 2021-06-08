```php
public function rules(): array
    {
        return [
           
            [
                'auto_day_value',
                'filter',
                'filter' => function ($value) {
                    if ($this->auto_day_type === self::WORKING_DAY && (int)$value > 1) {
                        $this->addError('auto_day_value', '自动结算日期类型为工作日,结算日期值只能为1天.');

                        return false;
                    }

                    return $value;
                },
            ],
            
        ];}
```
