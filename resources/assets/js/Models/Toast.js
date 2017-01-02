export class Toast {
    constructor(message, options = {}) {
        this.defaultOptions = {
            theme: 'default',
            timeLife: 5000,
            closeBtn: false,
        };
        this.message = message;
        this.options = Object.assign(this.defaultOptions, options);
        // this.createdAt = new Date();
    }

    getType() {
        if(!this.options.hasOwnProperty('type')) {
            return 'info';
        }

        return this.options.type;
    }
}