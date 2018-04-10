<template>
    <div class="message-wrapper clearfix">
        <div :class="{ 'message--by-me' : message.sent_by_me }" class="message">
            {{ message.message }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message']
    }
</script>
