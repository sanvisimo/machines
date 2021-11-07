<template>
    <div class="flex">
        <div v-for="(bread, index) in breadcrumb" :key="index">
            <span class="mx-1" v-if="index !== 0">></span>
            <router-link :to="bread.url">{{ bread.label }}</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Breadcrumb",
    data() {
      return {
          breadcrumb: ""
      }
    },
    created() {
        this.getBreadcrumb();
    },
    watch: {
        // call again the method if the route changes
        '$route': 'getBreadcrumb'
    },
    methods: {
        async getBreadcrumb() {
            console.log('route', this.$route.query)
            const { data } = await Nova.request().post(`/akka/panels/breadcrumb`,
            {
                params: this.$route.params,
                query: this.$route.query,
            });
            this.breadcrumb = data.breadcrumb;
            console.log('data', data)
        }
    }
}
</script>

<style scoped>

</style>
