<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="pageInfo.current_page === 1 ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="First"
                   @click="changePage(1)">
                    <span aria-hidden="true">&laquo;&laquo;</span>
                </a>
            </li>
            <li class="page-item" :class="pageInfo.current_page - 1 === 0 ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="Previous"
                   @click="changePage(pageInfo.current_page - 1)">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li v-for="i in PageNumbers" class="page-item" :class="pageInfo.current_page === i ? 'active' : ''">
                <a class="page-link" href="#" @click="changePage(i)">{{ i }}</a>
            </li>
            <li class="page-item" :class="pageInfo.current_page + 1 > pageInfo.last_page ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="Next"
                   @click="changePage(pageInfo.current_page + 1)">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li class="page-item" :class="pageInfo.current_page === pageInfo.last_page ? 'disabled' : ''">
                <a class="page-link" href="#" aria-label="Last"
                   @click="changePage(pageInfo.last_page)">
                    <span aria-hidden="true">&raquo;&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</template>

<!--Example: <Pagination :pageInfo="shorts" @onChangePage="getList"/> -->

<script>
    export default {
        props: ['pageInfo'],

        data() {
            return {}
        },
        methods: {
            changePage(page) {
                this.$emit('onChangePage', page);
            }
        },
        computed: {
            PageNumbers() {
                const bottom = this.pageInfo.current_page - 2 <= 0 ? 1 : this.pageInfo.current_page - 2;
                const top = bottom + 5 > this.pageInfo.last_page ? this.pageInfo.last_page : bottom + 5;
                const array = [];
                for (let i = bottom; i <= top; i++) {
                    array.push(i)
                }
                return array
            },
        },
        watch: {},
        components: {},
        mounted() {

        }
    }
</script>

<style scoped lang="scss">

</style>