<template>

    <div class="card horizontal bio card-company">
        <div class="card-company__image">
            <img class="bio--image img-responsive" :src="bio.img" :alt="bio.name" :title="bio.name">
        </div>
        <div class="card-company__bio">
            <div class="card-content company-info">
                <h4 v-text="bio.name"></h4>
                <p class="company-info" v-if="bio.body" v-text="bio.body"></p>
                <p class="company-info" v-else>No hay detalles sobre tu empresa</p>
            </div>
        </div>

        <bio-updateModal
            :url="url"
            :token="token"
            :organization="bio"></bio-updateModal>
    </div>

</template>

<script>
    export default {
        props: ['bio', 'url', 'token']
    }
</script>

<style type="text/css">
    .bio.card-company {
        width: calc(100% - 40px);
        margin: auto;
    }
</style>
