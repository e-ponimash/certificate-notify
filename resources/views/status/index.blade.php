
    <table>
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
                            {{$certificate->notified_at ? $certificate->notified_at->format('d.m.Y') : null}}
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

