@extends('layouts.main-layout')

@section('title', 'Patients')

@section('buttons')
    <a href="{{ route('patients.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{ route('patients.update', ['patient' => $data->id]) }}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-row">
                            <div class="form-group col-12">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name"
                                    value="{{ old('name') ?? $data->name }}" name="name" dir="auto">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone"
                                    value="{{ old('phone') ?? $data->phone }}" name="phone">
                                @error('phone')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="phone2">Phone 2</label>
                                <input type="text" class="form-control" id="phone2"
                                    value="{{ old('phone2') ?? $data->phone2 }}" name="phone2">
                                @error('phone2')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="date_of_birth">Date Of Birth</label>
                                <input type="date" class="form-control" id="date_of_birth"
                                    value="{{ old('date_of_birth') ?? $data->date_of_birth }}" name="date_of_birth">
                                @error('date_of_birth')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="gender">Gender</label>
                                <select id="gender" name="gender" class="form-control">
                                    <option {{ (old('gender') ?? $data->gender) == 'Male' ? 'selected' : '' }}
                                        value="Male">
                                        Male</option>
                                    <option {{ (old('gender') ?? $data->gender) == 'Female' ? 'selected' : '' }}
                                        value="Female">Female
                                    </option>
                                </select>
                                @error('gender')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="simple-select2">Nationality</label>
                                <select class="form-control select2" id="simple-select2" name="nationality">
                                    <option {{ old('nationality') ?? $data->nationality == 'afghan' ? 'selected' : '' }}
                                        value="afghan">Afghan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'albanian' ? 'selected' : '' }}
                                        value="albanian">Albanian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'algerian' ? 'selected' : '' }}
                                        value="algerian">Algerian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'american' ? 'selected' : '' }}
                                        value="american">American</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'andorran' ? 'selected' : '' }}
                                        value="andorran">Andorran</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'angolan' ? 'selected' : '' }}
                                        value="angolan">Angolan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'argentinian' ? 'selected' : '' }}
                                        value="argentinian">Argentinian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'armenian' ? 'selected' : '' }}
                                        value="armenian">Armenian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'australian' ? 'selected' : '' }}
                                        value="australian">Australian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'austrian' ? 'selected' : '' }}
                                        value="austrian">Austrian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'azerbaijani' ? 'selected' : '' }}
                                        value="azerbaijani">Azerbaijani</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bahamian' ? 'selected' : '' }}
                                        value="bahamian">Bahamian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bahraini' ? 'selected' : '' }}
                                        value="bahraini">Bahraini</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'bangladeshi' ? 'selected' : '' }}
                                        value="bangladeshi">Bangladeshi</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'barbadian' ? 'selected' : '' }}
                                        value="barbadian">Barbadian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'belarusian' ? 'selected' : '' }}
                                        value="belarusian">Belarusian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'belgian' ? 'selected' : '' }}
                                        value="belgian">Belgian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'belizean' ? 'selected' : '' }}
                                        value="belizean">Belizean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'beninese' ? 'selected' : '' }}
                                        value="beninese">Beninese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bhutanese' ? 'selected' : '' }}
                                        value="bhutanese">Bhutanese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bolivian' ? 'selected' : '' }}
                                        value="bolivian">Bolivian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bosnian' ? 'selected' : '' }}
                                        value="bosnian">Bosnian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'botswanan' ? 'selected' : '' }}
                                        value="botswanan">Botswanan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'brazilian' ? 'selected' : '' }}
                                        value="brazilian">Brazilian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'british' ? 'selected' : '' }}
                                        value="british">British</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bruneian' ? 'selected' : '' }}
                                        value="bruneian">Bruneian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'bulgarian' ? 'selected' : '' }}
                                        value="bulgarian">Bulgarian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'burkinabe' ? 'selected' : '' }}
                                        value="burkinabe">Burkinabe</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'burmese' ? 'selected' : '' }}
                                        value="burmese">Burmese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'burundian' ? 'selected' : '' }}
                                        value="burundian">Burundian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'cambodian' ? 'selected' : '' }}
                                        value="cambodian">Cambodian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'cameroonian' ? 'selected' : '' }}
                                        value="cameroonian">Cameroonian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'canadian' ? 'selected' : '' }}
                                        value="canadian">Canadian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'cape_verdean' ? 'selected' : '' }}
                                        value="cape_verdean">Cape Verdean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'central_african' ? 'selected' : '' }}
                                        value="central_african">Central African</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'chadian' ? 'selected' : '' }}
                                        value="chadian">Chadian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'chilean' ? 'selected' : '' }}
                                        value="chilean">Chilean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'chinese' ? 'selected' : '' }}
                                        value="chinese">Chinese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'colombian' ? 'selected' : '' }}
                                        value="colombian">Colombian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'comorian' ? 'selected' : '' }}
                                        value="comorian">Comorian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'congolese' ? 'selected' : '' }}
                                        value="congolese">Congolese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'costa_rican' ? 'selected' : '' }}
                                        value="costa_rican">Costa Rican</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'croatian' ? 'selected' : '' }}
                                        value="croatian">Croatian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'cuban' ? 'selected' : '' }}
                                        value="cuban">Cuban</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'cypriot' ? 'selected' : '' }}
                                        value="cypriot">Cypriot</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'czech' ? 'selected' : '' }}
                                        value="czech">Czech</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'danish' ? 'selected' : '' }}
                                        value="danish">Danish</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'djiboutian' ? 'selected' : '' }}
                                        value="djiboutian">Djiboutian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'dominican' ? 'selected' : '' }}
                                        value="dominican">Dominican</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'ecuadorian' ? 'selected' : '' }}
                                        value="ecuadorian">Ecuadorian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'egyptian' ? 'selected' : '' }}
                                        value="egyptian">Egyptian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'emirati' ? 'selected' : '' }}
                                        value="emirati">Emirati</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'equatorial_guinean' ? 'selected' : '' }}
                                        value="equatorial_guinean">Equatorial Guinean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'eritrean' ? 'selected' : '' }}
                                        value="eritrean">Eritrean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'estonian' ? 'selected' : '' }}
                                        value="estonian">Estonian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'ethiopian' ? 'selected' : '' }}
                                        value="ethiopian">Ethiopian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'fijian' ? 'selected' : '' }}
                                        value="fijian">Fijian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'filipino' ? 'selected' : '' }}
                                        value="filipino">Filipino</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'finnish' ? 'selected' : '' }}
                                        value="finnish">Finnish</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'french' ? 'selected' : '' }}
                                        value="french">French</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'gabonese' ? 'selected' : '' }}
                                        value="gabonese">Gabonese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'gambian' ? 'selected' : '' }}
                                        value="gambian">Gambian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'georgian' ? 'selected' : '' }}
                                        value="georgian">Georgian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'german' ? 'selected' : '' }}
                                        value="german">German</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'ghanaian' ? 'selected' : '' }}
                                        value="ghanaian">Ghanaian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'greek' ? 'selected' : '' }}
                                        value="greek">Greek</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'grenadian' ? 'selected' : '' }}
                                        value="grenadian">Grenadian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'guatemalan' ? 'selected' : '' }}
                                        value="guatemalan">Guatemalan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'guinean' ? 'selected' : '' }}
                                        value="guinean">Guinean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'guinea_bissauan' ? 'selected' : '' }}
                                        value="guinea_bissauan">Guinea-Bissauan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'guyanese' ? 'selected' : '' }}
                                        value="guyanese">Guyanese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'haitian' ? 'selected' : '' }}
                                        value="haitian">Haitian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'honduran' ? 'selected' : '' }}
                                        value="honduran">Honduran</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'hungarian' ? 'selected' : '' }}
                                        value="hungarian">Hungarian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'icelander' ? 'selected' : '' }}
                                        value="icelander">Icelander</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'indian' ? 'selected' : '' }}
                                        value="indian">Indian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'indonesian' ? 'selected' : '' }}
                                        value="indonesian">Indonesian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'iranian' ? 'selected' : '' }}
                                        value="iranian">Iranian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'iraqi' ? 'selected' : '' }}
                                        value="iraqi">Iraqi</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'irish' ? 'selected' : '' }}
                                        value="irish">Irish</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'israeli' ? 'selected' : '' }}
                                        value="israeli">Israeli</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'italian' ? 'selected' : '' }}
                                        value="italian">Italian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'ivorian' ? 'selected' : '' }}
                                        value="ivorian">Ivorian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'jamaican' ? 'selected' : '' }}
                                        value="jamaican">Jamaican</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'japanese' ? 'selected' : '' }}
                                        value="japanese">Japanese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'jordanian' ? 'selected' : '' }}
                                        value="jordanian">Jordanian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'kazakh' ? 'selected' : '' }}
                                        value="kazakh">Kazakh</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'kenyan' ? 'selected' : '' }}
                                        value="kenyan">Kenyan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'kittitian' ? 'selected' : '' }}
                                        value="kittitian">Kittitian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'kuwaiti' ? 'selected' : '' }}
                                        value="kuwaiti">Kuwaiti</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'kyrgyz' ? 'selected' : '' }}
                                        value="kyrgyz">Kyrgyz</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'laotian' ? 'selected' : '' }}
                                        value="laotian">Laotian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'latvian' ? 'selected' : '' }}
                                        value="latvian">Latvian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'lebanese' ? 'selected' : '' }}
                                        value="lebanese">Lebanese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'liberian' ? 'selected' : '' }}
                                        value="liberian">Liberian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'libyan' ? 'selected' : '' }}
                                        value="libyan">Libyan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'liechtensteiner' ? 'selected' : '' }}
                                        value="liechtensteiner">Liechtensteiner</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'lithuanian' ? 'selected' : '' }}
                                        value="lithuanian">Lithuanian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'luxembourger' ? 'selected' : '' }}
                                        value="luxembourger">Luxembourger</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'macedonian' ? 'selected' : '' }}
                                        value="macedonian">Macedonian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'malagasy' ? 'selected' : '' }}
                                        value="malagasy">Malagasy</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'malawian' ? 'selected' : '' }}
                                        value="malawian">Malawian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'malaysian' ? 'selected' : '' }}
                                        value="malaysian">Malaysian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'maldivian' ? 'selected' : '' }}
                                        value="maldivian">Maldivian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'malian' ? 'selected' : '' }}
                                        value="malian">Malian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'maltese' ? 'selected' : '' }}
                                        value="maltese">Maltese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'marshallese' ? 'selected' : '' }}
                                        value="marshallese">Marshallese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'mauritanian' ? 'selected' : '' }}
                                        value="mauritanian">Mauritanian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'mauritian' ? 'selected' : '' }}
                                        value="mauritian">Mauritian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'mexican' ? 'selected' : '' }}
                                        value="mexican">Mexican</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'micronesian' ? 'selected' : '' }}
                                        value="micronesian">Micronesian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'moldovan' ? 'selected' : '' }}
                                        value="moldovan">Moldovan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'monacan' ? 'selected' : '' }}
                                        value="monacan">Monacan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'mongolian' ? 'selected' : '' }}
                                        value="mongolian">Mongolian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'montenegrin' ? 'selected' : '' }}
                                        value="montenegrin">Montenegrin</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'moroccan' ? 'selected' : '' }}
                                        value="moroccan">Moroccan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'mozambican' ? 'selected' : '' }}
                                        value="mozambican">Mozambican</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'namibian' ? 'selected' : '' }}
                                        value="namibian">Namibian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'nauruan' ? 'selected' : '' }}
                                        value="nauruan">Nauruan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'nepalese' ? 'selected' : '' }}
                                        value="nepalese">Nepalese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'new_zealander' ? 'selected' : '' }}
                                        value="new_zealander">New Zealander</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'nicaraguan' ? 'selected' : '' }}
                                        value="nicaraguan">Nicaraguan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'nigerien' ? 'selected' : '' }}
                                        value="nigerien">Nigerien</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'nigerian' ? 'selected' : '' }}
                                        value="nigerian">Nigerian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'niuean' ? 'selected' : '' }}
                                        value="niuean">Niuean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'north_korean' ? 'selected' : '' }}
                                        value="north_korean">North Korean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'northern_irish' ? 'selected' : '' }}
                                        value="northern_irish">Northern Irish</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'norwegian' ? 'selected' : '' }}
                                        value="norwegian">Norwegian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'omani' ? 'selected' : '' }}
                                        value="omani">Omani</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'pakistani' ? 'selected' : '' }}
                                        value="pakistani">Pakistani</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'palauan' ? 'selected' : '' }}
                                        value="palauan">Palauan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'palestinian' ? 'selected' : '' }}
                                        value="palestinian">Palestinian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'panamanian' ? 'selected' : '' }}
                                        value="panamanian">Panamanian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'papua_new_guinean' ? 'selected' : '' }}
                                        value="papua_new_guinean">Papua New Guinean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'paraguayan' ? 'selected' : '' }}
                                        value="paraguayan">Paraguayan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'peruvian' ? 'selected' : '' }}
                                        value="peruvian">Peruvian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'polish' ? 'selected' : '' }}
                                        value="polish">Polish</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'portuguese' ? 'selected' : '' }}
                                        value="portuguese">Portuguese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'qatari' ? 'selected' : '' }}
                                        value="qatari">Qatari</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'romanian' ? 'selected' : '' }}
                                        value="romanian">Romanian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'russian' ? 'selected' : '' }}
                                        value="russian">Russian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'rwandan' ? 'selected' : '' }}
                                        value="rwandan">Rwandan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'saint_lucian' ? 'selected' : '' }}
                                        value="saint_lucian">Saint Lucian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'salvadoran' ? 'selected' : '' }}
                                        value="salvadoran">Salvadoran</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'samoan' ? 'selected' : '' }}
                                        value="samoan">Samoan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'san_marinese' ? 'selected' : '' }}
                                        value="san_marinese">San Marinese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'sao_tomean' ? 'selected' : '' }}
                                        value="sao_tomean">São Tomean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'saudi' ? 'selected' : '' }}
                                        value="saudi">Saudi</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'scottish' ? 'selected' : '' }}
                                        value="scottish">Scottish</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'senegalese' ? 'selected' : '' }}
                                        value="senegalese">Senegalese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'serbian' ? 'selected' : '' }}
                                        value="serbian">Serbian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'seychellois' ? 'selected' : '' }}
                                        value="seychellois">Seychellois</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'sierra_leonean' ? 'selected' : '' }}
                                        value="sierra_leonean">Sierra Leonean</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'singaporean' ? 'selected' : '' }}
                                        value="singaporean">Singaporean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'slovak' ? 'selected' : '' }}
                                        value="slovak">Slovak</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'slovenian' ? 'selected' : '' }}
                                        value="slovenian">Slovenian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'solomon_islander' ? 'selected' : '' }}
                                        value="solomon_islander">Solomon Islander</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'somali' ? 'selected' : '' }}
                                        value="somali">Somali</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'south_african' ? 'selected' : '' }}
                                        value="south_african">South African</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'south_korean' ? 'selected' : '' }}
                                        value="south_korean">South Korean</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'spanish' ? 'selected' : '' }}
                                        value="spanish">Spanish</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'sri_lankan' ? 'selected' : '' }}
                                        value="sri_lankan">Sri Lankan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'sudanese' ? 'selected' : '' }}
                                        value="sudanese">Sudanese</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'surinamer' ? 'selected' : '' }}
                                        value="surinamer">Surinamer</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'swazi' ? 'selected' : '' }}
                                        value="swazi">Swazi</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'swedish' ? 'selected' : '' }}
                                        value="swedish">Swedish</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'swiss' ? 'selected' : '' }}
                                        value="swiss">Swiss</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'syrian' ? 'selected' : '' }}
                                        value="syrian">Syrian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'taiwanese' ? 'selected' : '' }}
                                        value="taiwanese">Taiwanese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'tajik' ? 'selected' : '' }}
                                        value="tajik">Tajik</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'tanzanian' ? 'selected' : '' }}
                                        value="tanzanian">Tanzanian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'thai' ? 'selected' : '' }}
                                        value="thai">Thai</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'togolese' ? 'selected' : '' }}
                                        value="togolese">Togolese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'tongan' ? 'selected' : '' }}
                                        value="tongan">Tongan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'trinidadian_or_tobagonian' ? 'selected' : '' }}
                                        value="trinidadian_or_tobagonian">Trinidadian or Tobagonian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'tunisian' ? 'selected' : '' }}
                                        value="tunisian">Tunisian</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'turkish' ? 'selected' : '' }}
                                        value="turkish">Turkish</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'tuvaluan' ? 'selected' : '' }}
                                        value="tuvaluan">Tuvaluan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'ugandan' ? 'selected' : '' }}
                                        value="ugandan">Ugandan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'ukrainian' ? 'selected' : '' }}
                                        value="ukrainian">Ukrainian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'uruguayan' ? 'selected' : '' }}
                                        value="uruguayan">Uruguayan</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'uzbek' ? 'selected' : '' }}
                                        value="uzbek">Uzbek</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'vanuatuan' ? 'selected' : '' }}
                                        value="vanuatuan">Vanuatuan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'venezuelan' ? 'selected' : '' }}
                                        value="venezuelan">Venezuelan</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'vietnamese' ? 'selected' : '' }}
                                        value="vietnamese">Vietnamese</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'welsh' ? 'selected' : '' }}
                                        value="welsh">Welsh</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'yemenite' ? 'selected' : '' }}
                                        value="yemenite">Yemenite</option>
                                    <option {{ old('nationality') ?? $data->nationality == 'zambian' ? 'selected' : '' }}
                                        value="zambian">Zambian</option>
                                    <option
                                        {{ old('nationality') ?? $data->nationality == 'zimbabwean' ? 'selected' : '' }}
                                        value="zimbabwean">Zimbabwean</option>
                                </select>
                                @error('nationality')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div> <!-- form-group -->

                            <div class="form-group col-md-6">
                                <label for="need_invoice">Need Invoice</label>
                                <select id="need_invoice" name="need_invoice" class="form-control">
                                    <option {{ (old('need_invoice') ?? $data->need_invoice) == true ? 'selected' : '' }}
                                        value="1">Yes
                                    </option>
                                    <option {{ (old('need_invoice') ?? $data->need_invoice) == false ? 'selected' : '' }}
                                        value="0">No</option>
                                </select>
                                @error('need_invoice')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> <!-- /. card-body -->
            </div> <!-- /. card -->
        </div> <!-- /. col -->
    </div>
@endsection
