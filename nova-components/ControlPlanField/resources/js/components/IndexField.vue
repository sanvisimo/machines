<template>
    <create-form
        @resource-created="handleResourceCreated"
        @cancelled-create="handleCancelledCreate"
        mode="form"
        :resource-name="resourceName"
        :via-resource="viaResource"
        :via-resource-id="viaResourceId"
        :via-relationship="viaRelationship"
        :update-form-status="updateFormStatus"
        :should-override-meta="mode == 'form' ? true : false"
    />
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
