<template>

    <offer-list
        :url="url"
        :null_text="null_text"
        title="Featured offers"></offer-list>

</template>

<script>
    export default {
        data() {
            return {
                url: 'api/offer',
                null_text: 'No hay ofertas laborales patrocinadas!'
            }
        }
    }
</script>
