<template>
  <ul class="list-group">
    <li v-for="page in pages" :key="page.id" class="list-group-item">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <!-- Collapse Toggle -->
          <button
            v-if="page.children && page.children.length"
            class="btn btn-sm btn-outline-secondary me-2"
            @click="toggle(page.id)"
          >
            {{ isOpen(page.id) ? '▼' : '▶' }}
          </button>

          <strong>{{ page.title }}</strong>
        </div>

        <div>
          <button class="btn btn-sm btn-warning me-2" @click="$emit('edit-page', page)">
            ✏️ Edit
          </button>
          <button class="btn btn-sm btn-danger" @click="$emit('delete-page', page.id)">
            🗑️ Delete
          </button>
        </div>
      </div>

      <!-- Recursively render child pages if open -->
      <ul v-if="isOpen(page.id)" class="ms-4 mt-2">
        <PageTree
          :pages="page.children"
          @edit-page="$emit('edit-page', $event)"
          @delete-page="$emit('delete-page', $event)"
        />
      </ul>
    </li>
  </ul>
</template>

<script>
import { ref } from 'vue'

export default {
  name: 'PageTree',
  props: {
    pages: Array, // Nested page structure
  },
  emits: ['edit-page', 'delete-page'],
  setup() {
    const openPages = ref(new Set()) // Track open pages

    // Toggle page open/close
    const toggle = (id) => {
      if (openPages.value.has(id)) {
        openPages.value.delete(id)
      } else {
        openPages.value.add(id)
      }
    }

    // Check if a page is open
    const isOpen = (id) => openPages.value.has(id)

    return { toggle, isOpen }
  },
}
</script>

<style scoped>
.list-group-item {
  border-left: 4px solid #0d6efd;
}

.btn-sm {
  font-size: 0.8rem;
}
</style>
