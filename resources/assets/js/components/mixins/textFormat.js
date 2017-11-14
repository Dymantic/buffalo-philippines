export default {

    methods: {
        nl2br(text) {
            return text.replace(/(\n)/g, '<br>');
        }
    }
}