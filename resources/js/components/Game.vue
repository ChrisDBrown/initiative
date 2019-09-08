<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Game Component</div>

                    <div class="card-body">
                        {{ state }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: String
        },
        data() {
            return {
                state: null,
                loading: true
            }
        },
        mounted() {
            axios
                .get(`/api/${this.url}`)
                .then(response => {
                    this.state = response.data;
                    Echo.channel(`Game.${this.url}`)
                        .listen('.game.state_updated', (e) => {
                            this.state = e;
                        });
                });
        }
    }
</script>
