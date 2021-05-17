```php
<?=$form->field($model, 'endDate')->widget(DatePicker::class, [
    'options' => [
        $model->endDate = Carbon::parse($model->endDate)->toDateString(),
        'placeholder' => $model->getAttributeLabel('endDate'),
    ],
])?>
```
