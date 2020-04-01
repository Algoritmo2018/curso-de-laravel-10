<h1>Nova duvida</h1>

@if ($errors->any())
    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach
@endif

<form action="{{ route('supports.store') }}" method="post">
    {{-- <input type="hidden" value="{{csrf_token()}}" name="_token"> --}}
    @csrf()
    <input type="text" name="subject" id="" placeholder="Assunto" value="{{ old('subject') }}">
    <textarea name="body" id="" cols="30" rows="5" placeholder="Descrição">{{ old('body') }}</textarea>
    <button type="submit">Enviar</button>
</form>
