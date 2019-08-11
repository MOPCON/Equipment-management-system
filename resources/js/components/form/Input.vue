<template>
    <div class="form-group">
        <label>{{ label }}</label>
        <input class="form-control"
               :class="{'is-invalid': error}"
               v-bind="$attrs"
               @input="event => $emit('input', event.target.value)"
        />
        <div class="invalid-feedback">{{ error }}</div>
    </div>
</template>

<!--<Input type="password" label="舊密碼" :error="validation.firstError('oldPassword')" v-model="oldPassword"/>-->

<script>
    export default {
        props: {
            label: String,
            error: String
        },
    };
</script>

<style scoped lang="scss">

</style>
