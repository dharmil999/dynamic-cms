<template>
  <div class="container mt-4">
    <h1 class="text-center mb-4">Manage Pages</h1>

    <!-- Page Tree with CRUD -->
    <div class="card shadow p-3">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Page Structure</h3>
        <button class="btn btn-primary" @click="openModal(null)">➕ Add New Page</button>
      </div>
      <PageTree :pages="pages" @edit-page="openModal" @delete-page="deletePage" />
    </div>

    <!-- Bootstrap Modal for CRUD -->
    <div class="modal fade" id="pageModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">{{ editingPage?.id ? 'Edit Page' : 'Create New Page' }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="savePage">
              <div class="mb-3">
                <label class="form-label">Title</label>
                <input v-model="form.title" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Slug</label>
                <input v-model="form.slug" class="form-control" required />
              </div>
              <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea v-model="form.content" class="form-control"></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Parent Page</label>
                <select v-model="form.parent_id" class="form-select">
                  <option :value="null">None (Root Page)</option>
                  <option v-for="option in nestedPageOptions" :key="option.id" :value="option.id">
                    {{ option.label }}
                  </option>
                </select>
              </div>
              <button type="submit" class="btn btn-success w-100">
                {{ editingPage?.id ? 'Update Page' : 'Create Page' }}
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
import { fetchPages, createPage, updatePage, deletePage } from '../services/api'
import PageTree from '../components/PageTree.vue'
import bootstrap from 'bootstrap/dist/js/bootstrap.bundle.min.js'

export default {
  name: 'PageManagement',
  components: { PageTree },
  setup() {
    const pages = ref([])
    const form = ref({ title: '', slug: '', content: '', parent_id: null })
    const editingPage = ref(null)
    let modalInstance = null

    const loadPages = async () => {
      pages.value = await fetchPages()
    }

    const openModal = (page) => {
      if (page) {
        editingPage.value = page
        form.value = { ...page }
      } else {
        editingPage.value = null
        form.value = { title: '', slug: '', content: '', parent_id: null }
      }
      modalInstance = new bootstrap.Modal(document.getElementById('pageModal'))
      modalInstance.show()
    }

    const savePage = async () => {
      const pageData = {
        title: form.value.title,
        slug: form.value.slug,
        content: form.value.content,
        parent_id: form.value.parent_id,
      }

      if (editingPage.value) {
        await updatePage(editingPage.value.id, pageData)
      } else {
        await createPage(pageData)
      }

      modalInstance.hide()
      loadPages()
    }

    const deletePageFn = async (id) => {
      await deletePage(id)
      loadPages()
    }

    const generateNestedOptions = (pages, prefix = '') => {
      let options = []
      pages.forEach((page) => {
        options.push({ id: page.id, label: `${prefix}${page.title}` })
        if (page.children && page.children.length) {
          options = options.concat(generateNestedOptions(page.children, `${prefix}-- `))
        }
      })
      return options
    }

    const nestedPageOptions = computed(() => generateNestedOptions(pages.value))

    onMounted(loadPages)

    return {
      pages,
      form,
      editingPage,
      openModal,
      savePage,
      deletePage: deletePageFn,
      nestedPageOptions,
    }
  },
}
</script>
