<template>

    <div class="chat-detail">
        <div class="chat-detail__conversation">
            <chat-message v-for="message in messages" :key="message.id" :message="message"></chat-message>
            <p v-if="(!messages || messages.length < 1) && !chat_selected">Selecciona un chat</p>
        </div>
        <div v-if="chat_selected" class="chat-detail__form">
            <textarea v-model="new_message" placeholder="Aquí tu mensaje"></textarea>
            <button @click="sendMessage">Enviar</button>
        </div>
    </div>

</template>

<script>
    export default {

        // props: {
        //     chat_id: Number
        // },
        data() {
            return {
                chat_selected: false,
                chat_id: null,
                new_message: null,
                messages: [
                    //
                ]
            }
        },
        methods: {
            sendMessage() {
                if (this.new_message != null) {

                    let data = {
                        message: this.new_message,
                        chat_id: this.chat_id
                    }
                    axios.post('api/chats', data)
                        .then(res => {
                            this.getMessages(this.chat_id)
                        })
                        .catch(err => {
                            alert('Message couldnt be sent')
                        })

                    this.new_message = null
                }
            },
            getMessages(chat_id) {
                axios.get('api/chats/' + chat_id)
                    .then(res => {
                        this.messages = res.data
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }
        },
        mounted() {
            Event.$on('chatClicked', (data) => {
                this.chat_id = data.chat_id
                this.chat_selected = true
                this.getMessages(this.chat_id)
            })
        }

    }
</script>
