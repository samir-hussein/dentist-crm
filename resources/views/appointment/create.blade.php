@extends('layouts.main-layout')

@section('title', 'Appointment List')

@section('style')
    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

@section('buttons')
    <a href="{{ route('appointments.index') }}"><button type="button" class="btn btn-dark"><span
                class="fe fe-arrow-left fe-12 mr-2"></span>Back</button></a>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger d-none" id="patient-alert" role="alert">
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
            <div class="card shadow mb-4">
                <div class="card shadow">
                    <div class="card-body">
                        <ul class="nav nav-pills nav-fill mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home"
                                    role="tab" aria-controls="pills-home" aria-selected="true">New Patient</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Registered
                                    Patient</a>
                            </li>
                        </ul>
                        <div class="tab-content mb-1" id="pills-tabContent">
                            <div class="tab-pane fade active show" id="pills-home" role="tabpanel"
                                aria-labelledby="pills-home-tab">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('appointments.store') }}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-6">
                                                    <label for="name">Full Name</label>
                                                    <input type="text" class="form-control" id="name"
                                                        value="{{ old('name') }}" name="name" dir="auto">
                                                    @error('name')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-6">
                                                    <label for="simple-select3">Nationality</label>
                                                    <select class="form-control select2" id="simple-select3"
                                                        name="nationality">
                                                        <option {{ old('nationality') == 'afghan' ? 'selected' : '' }}
                                                            value="afghan">Afghan
                                                        </option>
                                                        <option {{ old('nationality') == 'albanian' ? 'selected' : '' }}
                                                            value="albanian">
                                                            Albanian</option>
                                                        <option {{ old('nationality') == 'algerian' ? 'selected' : '' }}
                                                            value="algerian">
                                                            Algerian</option>
                                                        <option {{ old('nationality') == 'american' ? 'selected' : '' }}
                                                            value="american">
                                                            American</option>
                                                        <option {{ old('nationality') == 'andorran' ? 'selected' : '' }}
                                                            value="andorran">
                                                            Andorran</option>
                                                        <option {{ old('nationality') == 'angolan' ? 'selected' : '' }}
                                                            value="angolan">Angolan
                                                        </option>
                                                        <option {{ old('nationality') == 'antiguan' ? 'selected' : '' }}
                                                            value="antiguan">
                                                            Antiguan</option>
                                                        <option {{ old('nationality') == 'argentine' ? 'selected' : '' }}
                                                            value="argentine">
                                                            Argentine</option>
                                                        <option {{ old('nationality') == 'armenian' ? 'selected' : '' }}
                                                            value="armenian">
                                                            Armenian</option>
                                                        <option {{ old('nationality') == 'australian' ? 'selected' : '' }}
                                                            value="australian">
                                                            Australian</option>
                                                        <option {{ old('nationality') == 'austrian' ? 'selected' : '' }}
                                                            value="austrian">
                                                            Austrian</option>
                                                        <option {{ old('nationality') == 'azerbaijani' ? 'selected' : '' }}
                                                            value="azerbaijani">Azerbaijani</option>
                                                        <option {{ old('nationality') == 'bahamian' ? 'selected' : '' }}
                                                            value="bahamian">
                                                            Bahamian</option>
                                                        <option {{ old('nationality') == 'bahraini' ? 'selected' : '' }}
                                                            value="bahraini">
                                                            Bahraini</option>
                                                        <option {{ old('nationality') == 'bangladeshi' ? 'selected' : '' }}
                                                            value="bangladeshi">Bangladeshi</option>
                                                        <option {{ old('nationality') == 'barbadian' ? 'selected' : '' }}
                                                            value="barbadian">
                                                            Barbadian</option>
                                                        <option {{ old('nationality') == 'belarusian' ? 'selected' : '' }}
                                                            value="belarusian">
                                                            Belarusian</option>
                                                        <option {{ old('nationality') == 'belgian' ? 'selected' : '' }}
                                                            value="belgian">Belgian
                                                        </option>
                                                        <option {{ old('nationality') == 'belizean' ? 'selected' : '' }}
                                                            value="belizean">
                                                            Belizean</option>
                                                        <option {{ old('nationality') == 'beninese' ? 'selected' : '' }}
                                                            value="beninese">
                                                            Beninese</option>
                                                        <option {{ old('nationality') == 'bhutanese' ? 'selected' : '' }}
                                                            value="bhutanese">
                                                            Bhutanese</option>
                                                        <option {{ old('nationality') == 'bolivian' ? 'selected' : '' }}
                                                            value="bolivian">
                                                            Bolivian</option>
                                                        <option {{ old('nationality') == 'bosnian' ? 'selected' : '' }}
                                                            value="bosnian">Bosnian
                                                        </option>
                                                        <option {{ old('nationality') == 'botswanan' ? 'selected' : '' }}
                                                            value="botswanan">
                                                            Botswanan</option>
                                                        <option {{ old('nationality') == 'brazilian' ? 'selected' : '' }}
                                                            value="brazilian">
                                                            Brazilian</option>
                                                        <option {{ old('nationality') == 'british' ? 'selected' : '' }}
                                                            value="british">British
                                                        </option>
                                                        <option {{ old('nationality') == 'bruneian' ? 'selected' : '' }}
                                                            value="bruneian">
                                                            Bruneian</option>
                                                        <option {{ old('nationality') == 'bulgarian' ? 'selected' : '' }}
                                                            value="bulgarian">
                                                            Bulgarian</option>
                                                        <option {{ old('nationality') == 'burkinabe' ? 'selected' : '' }}
                                                            value="burkinabe">
                                                            Burkinabe</option>
                                                        <option {{ old('nationality') == 'burmese' ? 'selected' : '' }}
                                                            value="burmese">Burmese
                                                        </option>
                                                        <option {{ old('nationality') == 'burundian' ? 'selected' : '' }}
                                                            value="burundian">
                                                            Burundian</option>
                                                        <option {{ old('nationality') == 'cambodian' ? 'selected' : '' }}
                                                            value="cambodian">
                                                            Cambodian</option>
                                                        <option {{ old('nationality') == 'cameroonian' ? 'selected' : '' }}
                                                            value="cameroonian">Cameroonian</option>
                                                        <option {{ old('nationality') == 'canadian' ? 'selected' : '' }}
                                                            value="canadian">
                                                            Canadian</option>
                                                        <option
                                                            {{ old('nationality') == 'cape_verdean' ? 'selected' : '' }}
                                                            value="cape_verdean">Cape Verdean</option>
                                                        <option
                                                            {{ old('nationality') == 'central_african' ? 'selected' : '' }}
                                                            value="central_african">Central African</option>
                                                        <option {{ old('nationality') == 'chadian' ? 'selected' : '' }}
                                                            value="chadian">Chadian
                                                        </option>
                                                        <option {{ old('nationality') == 'chilean' ? 'selected' : '' }}
                                                            value="chilean">Chilean
                                                        </option>
                                                        <option {{ old('nationality') == 'chinese' ? 'selected' : '' }}
                                                            value="chinese">Chinese
                                                        </option>
                                                        <option {{ old('nationality') == 'colombian' ? 'selected' : '' }}
                                                            value="colombian">
                                                            Colombian</option>
                                                        <option {{ old('nationality') == 'comoran' ? 'selected' : '' }}
                                                            value="comoran">
                                                            Comoran</option>
                                                        <option {{ old('nationality') == 'congolese' ? 'selected' : '' }}
                                                            value="congolese">
                                                            Congolese</option>
                                                        <option {{ old('nationality') == 'costa_rican' ? 'selected' : '' }}
                                                            value="costa_rican">Costa Rican</option>
                                                        <option {{ old('nationality') == 'croatian' ? 'selected' : '' }}
                                                            value="croatian">
                                                            Croatian</option>
                                                        <option {{ old('nationality') == 'cuban' ? 'selected' : '' }}
                                                            value="cuban">Cuban
                                                        </option>
                                                        <option {{ old('nationality') == 'cypriot' ? 'selected' : '' }}
                                                            value="cypriot">
                                                            Cypriot</option>
                                                        <option {{ old('nationality') == 'czech' ? 'selected' : '' }}
                                                            value="czech">Czech
                                                        </option>
                                                        <option {{ old('nationality') == 'danish' ? 'selected' : '' }}
                                                            value="danish">Danish
                                                        </option>
                                                        <option {{ old('nationality') == 'djiboutian' ? 'selected' : '' }}
                                                            value="djiboutian">
                                                            Djiboutian</option>
                                                        <option {{ old('nationality') == 'dominican' ? 'selected' : '' }}
                                                            value="dominican">
                                                            Dominican</option>
                                                        <option {{ old('nationality') == 'dutch' ? 'selected' : '' }}
                                                            value="dutch">Dutch
                                                        </option>
                                                        <option
                                                            {{ old('nationality') == 'east_timorese' ? 'selected' : '' }}
                                                            value="east_timorese">East Timorese</option>
                                                        <option {{ old('nationality') == 'ecuadorean' ? 'selected' : '' }}
                                                            value="ecuadorean">
                                                            Ecuadorean</option>
                                                        <option {{ old('nationality') == 'egyptian' ? 'selected' : '' }}
                                                            value="egyptian">
                                                            Egyptian</option>
                                                        <option {{ old('nationality') == 'emirati' ? 'selected' : '' }}
                                                            value="emirati">
                                                            Emirati</option>
                                                        <option
                                                            {{ old('nationality') == 'equatoguinean' ? 'selected' : '' }}
                                                            value="equatoguinean">Equatoguinean</option>
                                                        <option {{ old('nationality') == 'eritrean' ? 'selected' : '' }}
                                                            value="eritrean">
                                                            Eritrean</option>
                                                        <option {{ old('nationality') == 'estonian' ? 'selected' : '' }}
                                                            value="estonian">
                                                            Estonian</option>
                                                        <option {{ old('nationality') == 'ethiopian' ? 'selected' : '' }}
                                                            value="ethiopian">
                                                            Ethiopian</option>
                                                        <option {{ old('nationality') == 'fijian' ? 'selected' : '' }}
                                                            value="fijian">Fijian
                                                        </option>
                                                        <option {{ old('nationality') == 'filipino' ? 'selected' : '' }}
                                                            value="filipino">
                                                            Filipino</option>
                                                        <option {{ old('nationality') == 'finnish' ? 'selected' : '' }}
                                                            value="finnish">
                                                            Finnish</option>
                                                        <option {{ old('nationality') == 'french' ? 'selected' : '' }}
                                                            value="french">French
                                                        </option>
                                                        <option {{ old('nationality') == 'gabonese' ? 'selected' : '' }}
                                                            value="gabonese">
                                                            Gabonese</option>
                                                        <option {{ old('nationality') == 'gambian' ? 'selected' : '' }}
                                                            value="gambian">
                                                            Gambian</option>
                                                        <option {{ old('nationality') == 'georgian' ? 'selected' : '' }}
                                                            value="georgian">
                                                            Georgian</option>
                                                        <option {{ old('nationality') == 'german' ? 'selected' : '' }}
                                                            value="german">German
                                                        </option>
                                                        <option {{ old('nationality') == 'ghanaian' ? 'selected' : '' }}
                                                            value="ghanaian">
                                                            Ghanaian</option>
                                                        <option {{ old('nationality') == 'greek' ? 'selected' : '' }}
                                                            value="greek">Greek
                                                        </option>
                                                        <option {{ old('nationality') == 'grenadian' ? 'selected' : '' }}
                                                            value="grenadian">
                                                            Grenadian</option>
                                                        <option {{ old('nationality') == 'guatemalan' ? 'selected' : '' }}
                                                            value="guatemalan">
                                                            Guatemalan</option>
                                                        <option {{ old('nationality') == 'guinean' ? 'selected' : '' }}
                                                            value="guinean">
                                                            Guinean</option>
                                                        <option
                                                            {{ old('nationality') == 'guinea_bissauan' ? 'selected' : '' }}
                                                            value="guinea_bissauan">Guinea-Bissauan</option>
                                                        <option {{ old('nationality') == 'guyanese' ? 'selected' : '' }}
                                                            value="guyanese">
                                                            Guyanese</option>
                                                        <option {{ old('nationality') == 'haitian' ? 'selected' : '' }}
                                                            value="haitian">
                                                            Haitian</option>
                                                        <option {{ old('nationality') == 'honduran' ? 'selected' : '' }}
                                                            value="honduran">
                                                            Honduran</option>
                                                        <option {{ old('nationality') == 'hungarian' ? 'selected' : '' }}
                                                            value="hungarian">
                                                            Hungarian</option>
                                                        <option {{ old('nationality') == 'icelander' ? 'selected' : '' }}
                                                            value="icelander">
                                                            Icelander</option>
                                                        <option {{ old('nationality') == 'indian' ? 'selected' : '' }}
                                                            value="indian">Indian
                                                        </option>
                                                        <option {{ old('nationality') == 'indonesian' ? 'selected' : '' }}
                                                            value="indonesian">
                                                            Indonesian</option>
                                                        <option {{ old('nationality') == 'iranian' ? 'selected' : '' }}
                                                            value="iranian">
                                                            Iranian</option>
                                                        <option {{ old('nationality') == 'iraqi' ? 'selected' : '' }}
                                                            value="iraqi">Iraqi
                                                        </option>
                                                        <option {{ old('nationality') == 'irish' ? 'selected' : '' }}
                                                            value="irish">Irish
                                                        </option>
                                                        <option {{ old('nationality') == 'israeli' ? 'selected' : '' }}
                                                            value="israeli">
                                                            Israeli</option>
                                                        <option {{ old('nationality') == 'italian' ? 'selected' : '' }}
                                                            value="italian">
                                                            Italian</option>
                                                        <option {{ old('nationality') == 'ivorian' ? 'selected' : '' }}
                                                            value="ivorian">
                                                            Ivorian</option>
                                                        <option {{ old('nationality') == 'jamaican' ? 'selected' : '' }}
                                                            value="jamaican">
                                                            Jamaican</option>
                                                        <option {{ old('nationality') == 'japanese' ? 'selected' : '' }}
                                                            value="japanese">
                                                            Japanese</option>
                                                        <option {{ old('nationality') == 'jordanian' ? 'selected' : '' }}
                                                            value="jordanian">
                                                            Jordanian</option>
                                                        <option {{ old('nationality') == 'kazakh' ? 'selected' : '' }}
                                                            value="kazakh">Kazakh
                                                        </option>
                                                        <option {{ old('nationality') == 'kenyan' ? 'selected' : '' }}
                                                            value="kenyan">Kenyan
                                                        </option>
                                                        <option {{ old('nationality') == 'kiribati' ? 'selected' : '' }}
                                                            value="kiribati">
                                                            Kiribati</option>
                                                        <option {{ old('nationality') == 'kittitian' ? 'selected' : '' }}
                                                            value="kittitian">
                                                            Kittitian</option>
                                                        <option {{ old('nationality') == 'kosovar' ? 'selected' : '' }}
                                                            value="kosovar">
                                                            Kosovar</option>
                                                        <option {{ old('nationality') == 'kuwaiti' ? 'selected' : '' }}
                                                            value="kuwaiti">
                                                            Kuwaiti</option>
                                                        <option {{ old('nationality') == 'kyrgyz' ? 'selected' : '' }}
                                                            value="kyrgyz">Kyrgyz
                                                        </option>
                                                        <option {{ old('nationality') == 'lao' ? 'selected' : '' }}
                                                            value="lao">Lao
                                                        </option>
                                                        <option {{ old('nationality') == 'latvian' ? 'selected' : '' }}
                                                            value="latvian">
                                                            Latvian</option>
                                                        <option {{ old('nationality') == 'lebanese' ? 'selected' : '' }}
                                                            value="lebanese">
                                                            Lebanese</option>
                                                        <option {{ old('nationality') == 'liberian' ? 'selected' : '' }}
                                                            value="liberian">
                                                            Liberian</option>
                                                        <option {{ old('nationality') == 'libyan' ? 'selected' : '' }}
                                                            value="libyan">Libyan
                                                        </option>
                                                        <option
                                                            {{ old('nationality') == 'liechtenstein' ? 'selected' : '' }}
                                                            value="liechtenstein">Liechtenstein</option>
                                                        <option {{ old('nationality') == 'lithuanian' ? 'selected' : '' }}
                                                            value="lithuanian">Lithuanian</option>
                                                        <option
                                                            {{ old('nationality') == 'luxembourger' ? 'selected' : '' }}
                                                            value="luxembourger">Luxembourger</option>
                                                        <option {{ old('nationality') == 'macedonian' ? 'selected' : '' }}
                                                            value="macedonian">Macedonian</option>
                                                        <option {{ old('nationality') == 'malagasy' ? 'selected' : '' }}
                                                            value="malagasy">
                                                            Malagasy</option>
                                                        <option {{ old('nationality') == 'malawian' ? 'selected' : '' }}
                                                            value="malawian">
                                                            Malawian</option>
                                                        <option {{ old('nationality') == 'malaysian' ? 'selected' : '' }}
                                                            value="malaysian">
                                                            Malaysian</option>
                                                        <option {{ old('nationality') == 'maldivian' ? 'selected' : '' }}
                                                            value="maldivian">
                                                            Maldivian</option>
                                                        <option {{ old('nationality') == 'malian' ? 'selected' : '' }}
                                                            value="malian">Malian
                                                        </option>
                                                        <option {{ old('nationality') == 'maltese' ? 'selected' : '' }}
                                                            value="maltese">
                                                            Maltese</option>
                                                        <option
                                                            {{ old('nationality') == 'marshallese' ? 'selected' : '' }}
                                                            value="marshallese">Marshallese</option>
                                                        <option
                                                            {{ old('nationality') == 'mauritanian' ? 'selected' : '' }}
                                                            value="mauritanian">Mauritanian</option>
                                                        <option {{ old('nationality') == 'mauritian' ? 'selected' : '' }}
                                                            value="mauritian">
                                                            Mauritian</option>
                                                        <option {{ old('nationality') == 'mexican' ? 'selected' : '' }}
                                                            value="mexican">
                                                            Mexican</option>
                                                        <option
                                                            {{ old('nationality') == 'micronesian' ? 'selected' : '' }}
                                                            value="micronesian">Micronesian</option>
                                                        <option {{ old('nationality') == 'moldovan' ? 'selected' : '' }}
                                                            value="moldovan">
                                                            Moldovan</option>
                                                        <option {{ old('nationality') == 'monacan' ? 'selected' : '' }}
                                                            value="monacan">
                                                            Monacan</option>
                                                        <option {{ old('nationality') == 'mongolian' ? 'selected' : '' }}
                                                            value="mongolian">
                                                            Mongolian</option>
                                                        <option
                                                            {{ old('nationality') == 'montenegrin' ? 'selected' : '' }}
                                                            value="montenegrin">Montenegrin</option>
                                                        <option {{ old('nationality') == 'moroccan' ? 'selected' : '' }}
                                                            value="moroccan">
                                                            Moroccan</option>
                                                        <option {{ old('nationality') == 'mozambican' ? 'selected' : '' }}
                                                            value="mozambican">Mozambican</option>
                                                        <option {{ old('nationality') == 'namibian' ? 'selected' : '' }}
                                                            value="namibian">
                                                            Namibian</option>
                                                        <option {{ old('nationality') == 'nauruan' ? 'selected' : '' }}
                                                            value="nauruan">
                                                            Nauruan</option>
                                                        <option {{ old('nationality') == 'nepalese' ? 'selected' : '' }}
                                                            value="nepalese">
                                                            Nepalese</option>
                                                        <option
                                                            {{ old('nationality') == 'new_zealander' ? 'selected' : '' }}
                                                            value="new_zealander">New Zealander</option>
                                                        <option {{ old('nationality') == 'nicaraguan' ? 'selected' : '' }}
                                                            value="nicaraguan">Nicaraguan</option>
                                                        <option {{ old('nationality') == 'nigerien' ? 'selected' : '' }}
                                                            value="nigerien">
                                                            Nigerien</option>
                                                        <option {{ old('nationality') == 'nigerian' ? 'selected' : '' }}
                                                            value="nigerian">
                                                            Nigerian</option>
                                                        <option {{ old('nationality') == 'niuean' ? 'selected' : '' }}
                                                            value="niuean">Niuean
                                                        </option>
                                                        <option
                                                            {{ old('nationality') == 'north_korean' ? 'selected' : '' }}
                                                            value="north_korean">North Korean</option>
                                                        <option
                                                            {{ old('nationality') == 'northern_irish' ? 'selected' : '' }}
                                                            value="northern_irish">Northern Irish</option>
                                                        <option {{ old('nationality') == 'norwegian' ? 'selected' : '' }}
                                                            value="norwegian">
                                                            Norwegian</option>
                                                        <option {{ old('nationality') == 'omani' ? 'selected' : '' }}
                                                            value="omani">Omani
                                                        </option>
                                                        <option {{ old('nationality') == 'pakistani' ? 'selected' : '' }}
                                                            value="pakistani">
                                                            Pakistani</option>
                                                        <option {{ old('nationality') == 'palauan' ? 'selected' : '' }}
                                                            value="palauan">
                                                            Palauan</option>
                                                        <option {{ old('nationality') == 'panamanian' ? 'selected' : '' }}
                                                            value="panamanian">Panamanian</option>
                                                        <option
                                                            {{ old('nationality') == 'papua_new_guinean' ? 'selected' : '' }}
                                                            value="papua_new_guinean">Papua New Guinean</option>
                                                        <option {{ old('nationality') == 'paraguayan' ? 'selected' : '' }}
                                                            value="paraguayan">Paraguayan</option>
                                                        <option {{ old('nationality') == 'peruvian' ? 'selected' : '' }}
                                                            value="peruvian">
                                                            Peruvian</option>
                                                        <option {{ old('nationality') == 'polish' ? 'selected' : '' }}
                                                            value="polish">Polish
                                                        </option>
                                                        <option {{ old('nationality') == 'portuguese' ? 'selected' : '' }}
                                                            value="portuguese">Portuguese</option>
                                                        <option {{ old('nationality') == 'qatari' ? 'selected' : '' }}
                                                            value="qatari">Qatari
                                                        </option>
                                                        <option {{ old('nationality') == 'romanian' ? 'selected' : '' }}
                                                            value="romanian">
                                                            Romanian</option>
                                                        <option {{ old('nationality') == 'russian' ? 'selected' : '' }}
                                                            value="russian">
                                                            Russian</option>
                                                        <option {{ old('nationality') == 'rwandan' ? 'selected' : '' }}
                                                            value="rwandan">
                                                            Rwandan</option>
                                                        <option
                                                            {{ old('nationality') == 'salvadorean' ? 'selected' : '' }}
                                                            value="salvadorean">Salvadorean</option>
                                                        <option {{ old('nationality') == 'samoan' ? 'selected' : '' }}
                                                            value="samoan">Samoan
                                                        </option>
                                                        <option {{ old('nationality') == 'sao_tomean' ? 'selected' : '' }}
                                                            value="sao_tomean">Sao Tomean</option>
                                                        <option {{ old('nationality') == 'saudi' ? 'selected' : '' }}
                                                            value="saudi">Saudi
                                                        </option>
                                                        <option {{ old('nationality') == 'scottish' ? 'selected' : '' }}
                                                            value="scottish">
                                                            Scottish</option>
                                                        <option {{ old('nationality') == 'senegalese' ? 'selected' : '' }}
                                                            value="senegalese">Senegalese</option>
                                                        <option {{ old('nationality') == 'serbian' ? 'selected' : '' }}
                                                            value="serbian">
                                                            Serbian</option>
                                                        <option
                                                            {{ old('nationality') == 'seychellois' ? 'selected' : '' }}
                                                            value="seychellois">Seychellois</option>
                                                        <option
                                                            {{ old('nationality') == 'sierra_leonean' ? 'selected' : '' }}
                                                            value="sierra_leonean">Sierra Leonean</option>
                                                        <option
                                                            {{ old('nationality') == 'singaporean' ? 'selected' : '' }}
                                                            value="singaporean">Singaporean</option>
                                                        <option {{ old('nationality') == 'slovak' ? 'selected' : '' }}
                                                            value="slovak">Slovak
                                                        </option>
                                                        <option {{ old('nationality') == 'slovenian' ? 'selected' : '' }}
                                                            value="slovenian">
                                                            Slovenian</option>
                                                        <option
                                                            {{ old('nationality') == 'solomon_islander' ? 'selected' : '' }}
                                                            value="solomon_islander">Solomon Islander</option>
                                                        <option {{ old('nationality') == 'somali' ? 'selected' : '' }}
                                                            value="somali">Somali
                                                        </option>
                                                        <option
                                                            {{ old('nationality') == 'south_african' ? 'selected' : '' }}
                                                            value="south_african">South African</option>
                                                        <option
                                                            {{ old('nationality') == 'south_korean' ? 'selected' : '' }}
                                                            value="south_korean">South Korean</option>
                                                        <option
                                                            {{ old('nationality') == 'south_sudanese' ? 'selected' : '' }}
                                                            value="south_sudanese">South Sudanese</option>
                                                        <option {{ old('nationality') == 'spanish' ? 'selected' : '' }}
                                                            value="spanish">
                                                            Spanish</option>
                                                        <option {{ old('nationality') == 'sri_lankan' ? 'selected' : '' }}
                                                            value="sri_lankan">Sri Lankan</option>
                                                        <option {{ old('nationality') == 'sudanese' ? 'selected' : '' }}
                                                            value="sudanese">
                                                            Sudanese</option>
                                                        <option {{ old('nationality') == 'surinamer' ? 'selected' : '' }}
                                                            value="surinamer">
                                                            Surinamer</option>
                                                        <option {{ old('nationality') == 'swazi' ? 'selected' : '' }}
                                                            value="swazi">Swazi
                                                        </option>
                                                        <option {{ old('nationality') == 'swedish' ? 'selected' : '' }}
                                                            value="swedish">
                                                            Swedish</option>
                                                        <option {{ old('nationality') == 'swiss' ? 'selected' : '' }}
                                                            value="swiss">Swiss
                                                        </option>
                                                        <option {{ old('nationality') == 'syrian' ? 'selected' : '' }}
                                                            value="syrian">Syrian
                                                        </option>
                                                        <option {{ old('nationality') == 'taiwanese' ? 'selected' : '' }}
                                                            value="taiwanese">
                                                            Taiwanese</option>
                                                        <option {{ old('nationality') == 'tajik' ? 'selected' : '' }}
                                                            value="tajik">Tajik
                                                        </option>
                                                        <option {{ old('nationality') == 'tanzanian' ? 'selected' : '' }}
                                                            value="tanzanian">
                                                            Tanzanian</option>
                                                        <option {{ old('nationality') == 'thai' ? 'selected' : '' }}
                                                            value="thai">Thai
                                                        </option>
                                                        <option {{ old('nationality') == 'togolese' ? 'selected' : '' }}
                                                            value="togolese">
                                                            Togolese</option>
                                                        <option {{ old('nationality') == 'tongan' ? 'selected' : '' }}
                                                            value="tongan">Tongan
                                                        </option>
                                                        <option
                                                            {{ old('nationality') == 'trinidadian' ? 'selected' : '' }}
                                                            value="trinidadian">Trinidadian</option>
                                                        <option {{ old('nationality') == 'tunisian' ? 'selected' : '' }}
                                                            value="tunisian">
                                                            Tunisian</option>
                                                        <option {{ old('nationality') == 'turkish' ? 'selected' : '' }}
                                                            value="turkish">
                                                            Turkish</option>
                                                        <option {{ old('nationality') == 'tuvaluan' ? 'selected' : '' }}
                                                            value="tuvaluan">
                                                            Tuvaluan</option>
                                                        <option {{ old('nationality') == 'ugandan' ? 'selected' : '' }}
                                                            value="ugandan">
                                                            Ugandan</option>
                                                        <option {{ old('nationality') == 'ukrainian' ? 'selected' : '' }}
                                                            value="ukrainian">
                                                            Ukrainian</option>
                                                        <option {{ old('nationality') == 'uruguayan' ? 'selected' : '' }}
                                                            value="uruguayan">
                                                            Uruguayan</option>
                                                        <option {{ old('nationality') == 'uzbek' ? 'selected' : '' }}
                                                            value="uzbek">Uzbek
                                                        </option>
                                                        <option {{ old('nationality') == 'vanuatuan' ? 'selected' : '' }}
                                                            value="vanuatuan">
                                                            Vanuatuan</option>
                                                        <option {{ old('nationality') == 'venezuelan' ? 'selected' : '' }}
                                                            value="venezuelan">Venezuelan</option>
                                                        <option {{ old('nationality') == 'vietnamese' ? 'selected' : '' }}
                                                            value="vietnamese">Vietnamese</option>
                                                        <option {{ old('nationality') == 'welsh' ? 'selected' : '' }}
                                                            value="welsh">Welsh
                                                        </option>
                                                        <option {{ old('nationality') == 'yemeni' ? 'selected' : '' }}
                                                            value="yemeni">Yemeni
                                                        </option>
                                                        <option {{ old('nationality') == 'zambian' ? 'selected' : '' }}
                                                            value="zambian">
                                                            Zambian</option>
                                                        <option {{ old('nationality') == 'zimbabwean' ? 'selected' : '' }}
                                                            value="zimbabwean">Zimbabwean</option>
                                                    </select>
                                                    @error('nationality')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div> <!-- form-group -->
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="phone">Phone</label>
                                                    <input type="text" class="form-control" id="phone"
                                                        value="{{ old('phone') }}" name="phone">
                                                    @error('phone')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="phone2">Phone 2</label>
                                                    <input type="text" class="form-control" id="phone2"
                                                        value="{{ old('phone2') }}" name="phone2">
                                                    @error('phone2')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="date_of_birth">Date Of Birth</label>
                                                    <input type="date" class="form-control" id="date_of_birth"
                                                        value="{{ old('date_of_birth') }}" name="date_of_birth">
                                                    @error('date_of_birth')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="gender">Gender</label>
                                                    <select id="gender" name="gender" class="form-control">
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                    @error('gender')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="branch_id">Branch</label>
                                                    <select onchange="changeBranch(this)"
                                                        data-date-selector="new-sec-date"
                                                        data-doctor-selector="new-sec-doctor"
                                                        data-time-selector="new-sec-time" id="branch_id" name="branch_id"
                                                        class="branchs form-control">
                                                        <option data-doctors="{{ json_encode([]) }}"
                                                            data-dates="{{ json_encode([]) }}" value="0">Select
                                                            Branch</option>
                                                        @foreach ($data->branches as $branch)
                                                            <option data-dates="{{ json_encode($branch->schduleDates) }}"
                                                                data-doctors="{{ json_encode($branch->doctors) }}"
                                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                                                value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('branch_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="doctor_id">Dentist</label>
                                                    <select onchange="changeDoctor(this)"
                                                        data-date-selector="new-sec-date"
                                                        data-time-selector="new-sec-time" id="doctor_id" name="doctor_id"
                                                        class="new-sec-doctor form-control">
                                                    </select>
                                                    @error('doctor_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="simple-select6">Date</label>
                                                    <select onchange="chageDate(this)"
                                                        data-doctor-selector="new-sec-doctor"
                                                        data-time-selector="new-sec-time"
                                                        class="new-sec-date form-control select2" id="simple-select6"
                                                        name="date_id">
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="simple-select8">Time</label>
                                                    <div id="new-div-time">
                                                        <select class="new-sec-time form-control select2"
                                                            id="simple-select8" name="time_id">
                                                        </select>
                                                    </div>
                                                    <input name="urgent_time" id="new-time-inp" type="time"
                                                        class="form-control d-none">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitch1">
                                                        <label class="custom-control-label"
                                                            for="customSwitch1">Urgent</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="multi-select">Services</label>
                                                    <select multiple name="service_ids[]"
                                                        class="form-control select2-multi" id="multi-select">
                                                        @foreach ($data->services as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('service_ids')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="notes">Notes</label>
                                                    <textarea name="notes" class="form-control" id="" cols="30" rows="5">{{ old('notes') }}</textarea>
                                                    @error('notes')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div>




                            <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                                aria-labelledby="pills-profile-tab">
                                <div class="mb-4">
                                    <div class="card-body">
                                        <form action="{{ route('appointments.store') }}" method="post">
                                            @csrf
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="simple-select2">Patient</label>
                                                    <select id="patient-list" class="form-control select2"
                                                        id="simple-select2" name="patient_id">
                                                        <option value="0">Select Patient</option>
                                                        @foreach ($data->patients as $patient)
                                                            <option data-lab="{{ json_encode($patient->labOrder) }}"
                                                                {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                                                                value="{{ $patient->id }}">#{{ $patient->code }} |
                                                                {{ $patient->name }} |
                                                                {{ $patient->phone }} | {{ $patient->phone2 }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div> <!-- form-group -->
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="branch_id">Branch</label>
                                                    <select onchange="changeBranch(this)"
                                                        data-date-selector="old-sec-date"
                                                        data-doctor-selector="old-sec-doctor"
                                                        data-time-selector="old-sec-time" id="branch_id" name="branch_id"
                                                        class="branchs form-control">
                                                        <option data-doctors="{{ json_encode([]) }}"
                                                            data-dates="{{ json_encode([]) }}" value="0">Select
                                                            Branch</option>
                                                        @foreach ($data->branches as $branch)
                                                            <option data-dates="{{ json_encode($branch->schduleDates) }}"
                                                                data-doctors="{{ json_encode($branch->doctors) }}"
                                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}
                                                                value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('branch_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="doctor_id">Dentist</label>
                                                    <select onchange="changeDoctor(this)"
                                                        data-date-selector="old-sec-date"
                                                        data-time-selector="old-sec-time" id="doctor_id" name="doctor_id"
                                                        class="old-sec-doctor form-control">
                                                    </select>
                                                    @error('doctor_id')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-3">
                                                    <label for="simple-select16">Date</label>
                                                    <select onchange="chageDate(this)"
                                                        data-doctor-selector="old-sec-doctor"
                                                        data-time-selector="old-sec-time"
                                                        class="old-sec-date form-control select2" id="simple-select16"
                                                        name="date_id">
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="simple-select18">Time</label>
                                                    <div id="old-div-time">
                                                        <select class="old-sec-time form-control select2"
                                                            id="simple-select18" name="time_id">
                                                        </select>
                                                    </div>
                                                    <input name="urgent_time" id="old-time-inp" type="time"
                                                        class="form-control d-none">
                                                    <div class="custom-control custom-switch mt-2">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="customSwitch2">
                                                        <label class="custom-control-label"
                                                            for="customSwitch2">Urgent</label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="multi-select2" class="d-block">Services</label>
                                                    <select multiple name="service_ids[]"
                                                        class="form-control select2-multi d-block w-100"
                                                        id="multi-select2">
                                                        @foreach ($data->services as $service)
                                                            <option value="{{ $service->id }}">{{ $service->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="notes">Notes</label>
                                                    <textarea name="notes" class="form-control" id="" cols="30" rows="5">{{ old('notes') }}</textarea>
                                                    @error('notes')
                                                        <p style="color: red">* {{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </form>
                                    </div> <!-- /. card-body -->
                                </div> <!-- /. card -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- /. col -->
    </div>
@endsection

@section('script')
    <script>
        let branch = 0;
        let doctor = 0;
        let day = 0;
        let date = 0;

        $("#patient-list").change(function() {
            let labOrder = $(this).find('option:selected').data('lab');
            if (labOrder) {
                $("#patient-alert").removeClass("d-none");
                $("#patient-alert").html(
                    `There is lab work for this pateint in lab ${labOrder.name} sent at ${labOrder.sentFormated} received at ${labOrder.receivedFormated??""}`
                );
            } else {
                $("#patient-alert").addClass("d-none");
            }
        });

        function changeBranch(e) {
            let doctors = $(e).find("option:selected").data("doctors");
            let dates = $(e).find("option:selected").data("dates");
            let date_selector = $(e).data("date-selector");
            let doctor_selector = $(e).data("doctor-selector");
            let time_selector = $(e).data("time-selector");
            branch = $(e).val();

            console.log(date_selector);


            let options = `<option value="">Select Dentist</option>`;
            $.each(doctors, function(index, value) {
                options +=
                    `<option value="${value.id}" ${doctor == value.id?"selected":""}>${value.name}</option>`;
            });
            $("." + doctor_selector).html(options);

            options = `<option value="">Select Date</option>`;
            $.each(dates, function(index, value) {
                options +=
                    `<option data-day-id="${value.schdule_day_id}" ${date == value.id?"selected":""} value="${value.id}">${value.dateFormated}</option>`;
            });
            $("." + date_selector).html(options);
            getTimes(time_selector);
        }

        function changeDoctor(e) {
            doctor = $(e).val();
            let date_selector = $(e).data("date-selector");
            let time_selector = $(e).data("time-selector");

            $.ajax({
                url: "/schdule-date-times/dates/" + branch + "/" + doctor,
                type: "GET",
                success: function(response) {
                    options = `<option value="">Select Date</option>`;
                    $.each(response, function(index, value) {
                        options +=
                            `<option data-day-id="${value.schdule_day_id}" ${date == value.id?"selected":""} value="${value.id}">${value.dateFormated}</option>`;
                    });
                    $("." + date_selector).html(options);
                    getTimes(time_selector);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        function chageDate(e) {
            day = $(e).find("option:selected").data("day-id");
            let time_selector = $(e).data("time-selector");
            let doctor_selector = $(e).data("doctor-selector");
            date = $(e).val();

            $.ajax({
                url: "/schdule-date-times/doctors/" + branch + "/" + day,
                type: "GET",
                success: function(response) {
                    let options = `<option value="">Select Dentist</option>`;
                    $.each(response, function(index, value) {
                        options +=
                            `<option value="${value.id}" ${doctor == value.id?"selected":""}>${value.name}</option>`;
                    });
                    $("." + doctor_selector).html(options);
                    getTimes(time_selector);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        function getTimes(time_selector) {
            $.ajax({
                url: "/schdule-date-times/times/" + branch + "/" + doctor + "/" + date,
                type: "GET",
                success: function(response) {
                    let options = `<option value="">Select Time</option>`;
                    $.each(response, function(index, value) {
                        options +=
                            `<option value="${value.id}">${value.timeFormated}</option>`;
                    });
                    $("." + time_selector).html(options);
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            })
        }

        $('#customSwitch1').on('change', function() {
            if ($(this).is(':checked')) {
                $("#new-div-time").addClass("d-none");
                $("#new-time-inp").removeClass("d-none");
                $("#simple-select8").val("");
            } else {
                $("#new-time-inp").addClass("d-none");
                $("#new-div-time").removeClass("d-none");
            }
        });

        $('#customSwitch2').on('change', function() {
            if ($(this).is(':checked')) {
                $("#old-div-time").addClass("d-none");
                $("#old-time-inp").removeClass("d-none");
                $("#simple-select18").val("");
            } else {
                $("#old-time-inp").addClass("d-none");
                $("#old-div-time").removeClass("d-none");
            }
        });
    </script>
@endsection
