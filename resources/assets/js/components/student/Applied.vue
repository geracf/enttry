<template>

    <offer-list
        :url="url"
        :null_text="null_text"
        title="Applied offers"></offer-list>

</template>

<script>
    export default {
        data() {
            return {
                url: 'api/applied',
                null_text: 'No has aplicado a ninguna oferta laboral!'

            }
        }
    }
</script>
