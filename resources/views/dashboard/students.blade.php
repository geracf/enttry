<div class="arena--full-height">
    <div class="row no-padding">
        <div class="col-xs-12 col-sm-6 col-lg-10 no-padding">
            <div class="row no-padding">
                {{-- <student-featured></student-featured> --}}
                {{-- <a href="{{ url("home", ['name' => 'dolor']) }}">Loquilla</a> --}}
                <offer-list
                    url="api/offer"
                    null_text="No hay ofertas laborales patrocinadas!"
                    title="Nuevas ofertas"></offer-list>
            </div>
            <div class="row no-padding">
                {{-- <student-applied></student-applied> --}}
                <offer-list
                    url="api/applied"
                    :paginated="false"
                    null_text="No has aplicado a ninguna oferta laboral!"
                    title="Ofertas que has aplicado"></offer-list>
            </div>
        </div>
        <div class="hidden-xs col-sm-4 col-lg-2 no-padding" style="min-width: 303px; position: fixed; top: 0; right: 0;">
            <student-cv></student-cv>
        </div>
    </div>
</div>
