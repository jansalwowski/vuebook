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

                <create-post-panel></create-post-panel>

                <hr>

                <user-wall></user-wall>
            </div>
        </div>
    </div>
</template>


<script type="text/babel">
    import CreatePostPanel from '../components/CreatePostPanel.vue';
    import UserWall from '../components/UserWall.vue';

    export default {
        components: {
            CreatePostPanel,
            UserWall
        }
    }
</script>