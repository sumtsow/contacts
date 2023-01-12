<template>
  <tr :ref="'row-' + group.id" class="position-relative" :class="{ 'text-muted': (group && !group.enabled) }" :id="'group-' + group.id" data-bs-toggle="modal" data-bs-target="#groupEditModal" style="cursor: pointer" @click="handler(group)">
      <td>{{ group.id }}</td>
      <td>{{ group.title }}</td>
      <td>{{ parent ? parent.title : '' }}</td>
      <td>
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" :id="['enabled-' + group.id]" :checked="group.enabled > 0" disabled />
          <label class="form-check-label" :for="['enabled-' + group.id]" />
        </div>
      </td>
      <td>{{ new Date(group.created_at).toLocaleString() }}</td>
      <td>{{ new Date(group.updated_at).toLocaleString() }}</td>
  </tr>
  <template v-for="child of group.children">
    <table-row :group="child" :parent="group" :handler="handler"></table-row>
  </template>
</template>
 
<script>
	export default {
		props: [ 'group', 'parent', 'handler' ],
	};
</script>