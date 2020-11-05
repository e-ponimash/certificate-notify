Добрый день!
Необходимо обновить сертификат Банка Русский Стандарт по следующей организации:
MerchantID: {{$certificate->merchant_id}}
Наименование: {{$certificate->name}}
Юридическое лицо: {{$certificate->legal_name}}
Срок действия сертификата: {{ \Carbon\Carbon::parse($certificate->expired_at)->format('d.m.Y')}}
