@extends('layouts.app')
@section('content')
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>MerchantId</th>
            <th>Name</th>
            <th>Legal name</th>
            <th>Expired at</th>
            <th>Notified at</th>
        </tr>
        </thead>
            @forelse($certificates as $certificate)

                    <tr>
                        <td>
                            {{$certificate->merchant_id}}
                        </td>
                        <td>
                            {{$certificate->name}}
                        </td>
                        <td>
                            {{$certificate->legal_name}}
                        </td>
                        <td>
                            {{$certificate->expired_at ? $certificate->expired_at->format('d.m.Y') : null}}
                        </td>
                        <td>
                            {{$certificate->notified_at ? $certificate->notified_at->format('d.m.Y H:i') : null}}
                        </td>
                    </tr>

            @empty
                <tr>
                    <td>
                        Список сертификатов пуст
                    </td>
                </tr>
            @endforelse
        </tr>
    </table>
    {{$certificates->links()}}
@endsection