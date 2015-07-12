@foreach ($contacts['not_invited'] as $contact)
	<br>{{ $contact['email'] }}
@endforeach
