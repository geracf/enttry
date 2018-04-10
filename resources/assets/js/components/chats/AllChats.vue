<template>

    <div class="chat-list">
        <div class="chat__title">
            <h1>Todos los chats</h1>
        </div>
        <div class="row">
            <div class="col-xs-12 chat" v-for="chat of chats" :class="{ 'chat--active' : chat.active }">
                <div class="row">
                    <div class="col-xs-3 chat__img" @click="chatClicked(chat)">
                        <img class="img-circle" :src="chat.subject_avatar" :alt="chat.subject_name" :title="chat.subject_name">
                    </div>
                    <div class="col-xs-9 chat__contents">
                        <div>
                            <h4 v-text="chat.subject_name" @click="chatClicked(chat)"></h4>
                            <i class="fa fa-ellipsis-v pull-right" @click="optionsClicked(chat)"></i>
                        </div>
                        <p v-text="chat.last_message" @click="chatClicked(chat)"></p>
                    </div>
                </div>
            </div>
            <div v-if="!chats || chats.length < 1">
                <p>No hay chats para mostrar</p>
            </div>
        </div>
    </div>

</template>

<script>
export default {

    data() {

        return {
            chats: [
                { id: 0, subject_avatar: '', subject_name: '', last_message: '' }
            ]
        }

    },

    methods: {
        chatClicked(chat) {
            this.chats.filter(function (prop) {
                if (prop.active) prop.active = false
            })
            Event.$emit('chatClicked', { chat_id: chat.id })
            chat.active = true
        },

        optionsClicked(chat) {
            alert('Options for: ' + chat.subject_name);
        }
    },
    mounted() {
        axios.get('api/chats')
            .then(res => {
                console.log(res.data)
                this.chats = res.data
            })
            .catch(err => {
                console.log(err)
            })
    }
}
</script>
