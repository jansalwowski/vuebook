export default class FormErrors {

    constructor(errors = {}) {
        this.setErrors(errors);
    }

    get(field) {
        if (this.has(field)) {
            return this.errors[field][0];
        }

        return null;
    }

    clear(field) {
        if (this.has(field)) {
            delete this.errors[field];
        }
    }

    has(field) {
        return this.errors.hasOwnProperty(field) && this.errors[field].length > 0;
    }

    setErrors(errors = {}) {
        if( typeof errors === 'object' ) {
            this.errors = errors;
        }
    }

    getErrors() {
        return this.errors;
    }

    any() {
        return Object.keys(this.errors).length > 0;
    }

}