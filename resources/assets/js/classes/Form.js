import FormErrors from './FormErrors';

export default class Form {
    constructor(data) {
        this.originalData = data;
        this.errors = new FormErrors();

        this.parseData(data);
    }

    getData() {
        let data = Object.assign({}, this);

        delete data.originalData;
        delete data.errors;

        return data;
    }

    parseData(data) {
        for (let field in data) {
            if (data.hasOwnProperty(field)) {
                this[field] = data[field];
            }
        }
    }

    reset() {
        this.parseData(this.originalData);
    }

    clear() {
        for (let field in this.originalData) {
            if (this.originalData.hasOwnProperty(field)) {
                this[field] = '';
            }
        }
    }

    setErrors(errors) {
        this.errors.setErrors(errors);
    }
}