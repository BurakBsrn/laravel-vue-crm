class Notification {
    parser(message) {
        if (typeof message === 'object' && message !== null) {
            let parse;
            if (message.success === false) {
                console.log('errors: ', message);
                parse = {...message.data}.errors
                    ?? {...message.data}.text
                    ?? {...message.data}.messages
                    ?? {...message.data}.message
                    ?? {generic: 'Bir hata oluştu'};
            } else {
                parse = {...message.data}.text
                    ?? {...message.data}.message
                    ?? {...message.data}.status
                    ?? {generic: 'Başarılı'};
            }
            return typeof parse === 'object' && true ? Object.values(parse).join('\n') : parse;
        } else {
            return message;
        }
    }

    async success(message) {
        if (message === undefined) {
            return;
        }
        const parseMessage = this.parser(message);
        if (typeof parseMessage !== 'string' || parseMessage.length < 1){
            return;
        }
        window.Toast.fire({
            icon: 'success',
            title: message?.message,
            text: parseMessage,
        });
    }

    async error(message) {
        if (message === undefined) {
            return;
        }
        const parseMessage = this.parser(message);
        if (typeof parseMessage !== 'string' || parseMessage.length < 1){
            return;
        }
        window.Toast.fire({
            icon: 'error',
            title: message?.message,
            text: parseMessage,
        })
    }
}

export default Notification = new Notification();
