<template>
    <div class="container">
        <div class="row">

            <div class="col-md-2">
            </div>

            <div class="col-md-10">
                <wall></wall>
            </div>
        </div>
    </div>
</template>


<script type="text/babel">
    import Wall from '../components/Wall.vue';

    export default {
        components: {
            Wall
        }
    }
</script>