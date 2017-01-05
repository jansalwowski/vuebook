<template>
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <div class="panel">
                    <div class="panel-body">
                        User Info
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <user-wall></user-wall>
            </div>
        </div>
    </div>
</template>


<script type="text/babel">
    import UserWall from '../components/UserWall.vue';

    export default {
        components: {
            UserWall
        }
    }
</script>