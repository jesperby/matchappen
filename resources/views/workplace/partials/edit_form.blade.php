<form method="POST" action="{{ action('WorkplaceController@update', $workplace->getKey()) }}">
  {!! csrf_field() !!}

  @if (count($errors) > 0)
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  <div>
    Namn
    <input type="text" name="name" value="{{ old('name', $workplace->name) }}">
  </div>

  <div>
    Antal anställda
    <input type="number" name="employees" min="1" max="65535" value="{{ old('employees', $workplace->employees) }}">
  </div>

  <div>
    Kontaktperson
    <input type="text" name="contact_name" value="{{ old('contact_name', $workplace->contact_name) }}" placeholder="{{ $workplace->fallback_contact_name }}">
  </div>

  <div>
    <button type="submit">Spara</button>
  </div>
</form>