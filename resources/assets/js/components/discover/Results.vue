<template>

    <div class="row result-container">
        <div class="col-xs-12 col-sm-6 col-md-3 no-padding" v-for="result of results">
            <div class="card result">
                <div class="row no-left-padding">
                    <div class="result__image pull-left">
                        <img class="result__image" :src="result.pic_url" :title="result.name" :alt="result.name">
                    </div>
                    <div class="result__text pull-right">
                        <p class="name" v-text="result.name"></p>
                        <p v-text="result.foi"></p>
                        <hr>
                        <p v-text="result.university"></p>
                        <p v-text="result.major"></p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
  export default {
    data () {

        return {

            results: [
                // { id: 1, name: 'Seonyeong Kim', foi: 'Networks', pic_url: '/img/lapiz.png', university: 'ITESM', major: 'ITIC' },
                // { id: 2, name: 'Carolina Ortega', foi: 'Accounting', pic_url: '/img/lapiz.png', university: 'ITESM', major: 'LEF' },
                // { id: 3, name: 'Juan Antonio', foi: 'Law', pic_url: '/img/lapiz.png', university: 'ITESM', major: 'LED' },
                // { id: 4, name: 'Adres Peruyero', foi: 'Coding', pic_url: '/img/lapiz.png', university: 'ITESM', major: 'ITIC' },
            ],

        }

    }
  }
</script>
