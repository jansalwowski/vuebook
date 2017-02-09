<template>
    <div class="typeahead">
        <input type="text"
               class="form-control typeahead__input"
               placeholder="Search twitter user"
               autocomplete="off"
               v-model="query"
               @keydown.down="down"
               @keydown.up="up"
               @keydown.enter="hit"
               @keydown.esc="reset"
               @blur="reset"
               @input="update"/>

        <div class="typeahead__icons">
            <i class="fa fa-spinner fa-spin" v-if="loading"></i>
            <template v-else>
                <i class="fa fa-search" v-show="isEmpty"></i>
                <i class="fa fa-times" v-show="isDirty" @click="reset"></i>
            </template>
        </div>

        <ul v-show="hasItems">
            <li v-for="(item, index) in items" :class="activeClass(index)" @mousedown="hit" @mousemove="setActive(index)">
                <avatar :user="item" style="display: inline; padding-right: 5px;"></avatar>
                <span class="name" v-text="item.name" style="display: inline;"></span>
            </li>
        </ul>
    </div>
</template>

<script>
    import Vuetypeahead from 'vue-typeahead'
    import Avatar from '../images/Avatar.vue'

    export default {
        extends: Vuetypeahead,

        data () {
            return {
                src: '/api/users/search?',
                limit: 5,
                minChars: 3,
                queryParamName: 'term'
            }
        },

        methods: {
            onHit (item) {
                this.$router.replace('/'+item.username);
            }
        },

        components: {
            Avatar
        }
    }
</script>


<style scoped>
    .typeahead {
        margin-top: 2px;
        position: relative;
        width: 350px;
    }

    .typeahead__icons {
        float: right;
        position: absolute;
        top: 16px;
        right: 15px;
        opacity: 0.4;
    }


    .typeahead__input {
        line-height: 1.42857143;
        padding: 23px 26px;
    }

    .typeahead__input:not(:focus) {
        border: none;
    }

    .fa-times {
        cursor: pointer;
    }

    ul {
        position: absolute;
        padding: 0;
        margin-top: 8px;
        min-width: 100%;
        background-color: #fff;
        list-style: none;
        border-radius: 4px;
        box-shadow: 0 0 10px rgba(0,0,0, 0.25);
        z-index: 1000;
    }

    li {
        padding: 10px 16px;
        border-bottom: 1px solid #ccc;
        cursor: pointer;
    }

    li:first-child {
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
    }

    li:last-child {
        border-bottom-left-radius: 4px;
        border-bottom-right-radius: 4px;
        border-bottom: 0;
    }

    span {
        display: block;
        color: #2c3e50;
    }

    .active {
        background-color: #13d3ff;
    }

    .active span {
        color: white;
    }

    .name {
        font-weight: 700;
        font-size: 18px;
    }

    .screen-name {
        font-style: italic;
    }
</style>