<template>
  <div class="card mt-3">
    <div class="card-body">
      <div class="card-title">
        <h3>Chat Group</h3>
        <hr>
      </div>
      <div class="card-body">
        <div class="messages" />
      </div>
    </div>
    <div class="card-footer">
      <form @submit.prevent="sendMessage">
        <div class="gorm-group">
          <label for="user">User:</label>
          <input
            v-model="user"
            type="text"
            class="form-control"
          >
        </div>
        <div class="gorm-group pb-3">
          <label for="message">Message:</label>
          <input
            v-model="message"
            type="text"
            class="form-control"
          >
        </div>
        <button
          type="submit"
          class="btn btn-success"
        >
          Send
        </button>
      </form>
    </div>
  </div>
</template>
