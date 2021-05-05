<template>
    <v-card
    elevation="2"
    >
        <v-card-title>
            {{ article.title }}
        </v-card-title>

        <v-card-subtitle>
            {{ article.autor.name }}
        </v-card-subtitle>

        <v-card-text>
            {{ article.content }}
        </v-card-text>

        <v-card-actions>
            <v-btn
                text
                to="/articles"
            >
                Back
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        props: ['id', 'lang'],
        data () {
            return {
                tab: null,
                items: [

                ]
            }
        },
        computed: {
             ...mapState({
                loading: state => state.articleService.loading,
                article: state => state.articleService.item
            })
        },
        methods: {
            ...mapActions('articleService', ['obtainArticle']),
        },
        created() {
            this.obtainArticle(this.id);
        }
    }
</script>

