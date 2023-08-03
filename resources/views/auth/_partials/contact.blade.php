


<div class="border-b border-gray-900/10 pb-12 pt-6">
    @csrf
    <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
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
                <x-input-label for="info" :value="__('Info')" />
                <x-text-input id="info" class="block mt-1 w-full" type="text" name="contacts[0][info]" :value="old('info')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('info')" class="mt-2" />
            </div>


            <button type="button" class="remover-contato mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Remover Contato
            </button>

            <button type="button" id="adicionar-contato" class="mt-4 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Adicionar Contato
            </button>
        </div>
    </div>




</div>

    <script>
        let contadorContatos = 1;
        // Função para clonar os campos de contato
        function clonarCampoContato() {
            const camposContatoContainer = document.querySelector('.contatos-container');
            const camposContatoOriginal = camposContatoContainer.querySelector('.contato');

            contadorContatos++;

            const novoCampoContato = camposContatoOriginal.cloneNode(true);

            const camposClonados = novoCampoContato.querySelectorAll('[name^="contacts["]');
            camposClonados.forEach((campo) => {
                const nomeAntigo = campo.getAttribute('name');
                campo.setAttribute('name', nomeAntigo.replace('contacts[0]', `contacts[${contadorContatos}]`));
            });

            camposContatoContainer.appendChild(novoCampoContato);

            novoCampoContato.querySelector('.remover-contato').addEventListener('click', () => {novoCampoContato.remove();});
        }

        document.getElementById('adicionar-contato').addEventListener('click', clonarCampoContato);
    </script>
