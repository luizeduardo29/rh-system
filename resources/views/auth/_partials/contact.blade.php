
<h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>

<div class="border-b border-gray-900/10 pb-12 pt-6">
    @csrf

    <!-- Container para os campos de contato -->
    <div class="contatos-container">
        <div class="contato">
            <div class="mt-4">
                <label for="grid-state" class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">Marital Status</label>
                <select name="contacts[0][typeContact]" class="form-select" required>
                    @foreach(array_column(\App\Enums\TypeContact::cases(), 'value') as $option)
                        <option value="{{$option}}">{{$option}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="contacts[0][info]" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Botão para remover o contato -->
            <button type="button" class="remover-contato mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Remover Contato
            </button>
        </div>
    </div>

    <!-- Botão para adicionar mais campos de contato -->
    <button type="button" id="adicionar-contato" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Adicionar Contato
    </button>
</div>

@section('scripts')
    <script>
        // Contador para criar IDs únicos para os campos clonados
        let contadorContatos = 1;

        // Função para clonar os campos de contato
        function clonarCampoContato() {
            const camposContatoContainer = document.querySelector('.contatos-container');
            const camposContatoOriginal = camposContatoContainer.querySelector('.contato');

            // Incrementar o contador para evitar IDs duplicados
            contadorContatos++;

            // Criar uma cópia do campo original
            const novoCampoContato = camposContatoOriginal.cloneNode(true);

            // Atualizar os atributos 'name' e 'id' dos campos clonados
            const camposClonados = novoCampoContato.querySelectorAll('[name^="contacts["]');
            camposClonados.forEach((campo) => {
                const nomeAntigo = campo.getAttribute('name');
                campo.setAttribute('name', nomeAntigo.replace('contacts[0]', `contacts[${contadorContatos}]`));
            });

            // Adicionar os campos clonados após o último campo original
            camposContatoContainer.appendChild(novoCampoContato);

            // Botão "Remover Contato" do campo clonado
            novoCampoContato.querySelector('.remover-contato').addEventListener('click', () => {
                novoCampoContato.remove(); // Remover o campo clonado quando o botão "Remover Contato" é clicado
            });
        }

        // Botão Adicionar Contato
        document.getElementById('adicionar-contato').addEventListener('click', clonarCampoContato);
    </script>
@endsection
