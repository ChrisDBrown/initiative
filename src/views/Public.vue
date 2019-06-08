<template>
  <v-container>
    <v-jumbotron
      v-if="state === 'STATE_OUT_OF_COMBAT'"
      color="primary"
      dark
    >
      <v-container fill-height>
        <v-layout align-center>
          <v-flex text-xs-center>
            <h3 class="display-3">
              Safe, for now
            </h3>
          </v-flex>
        </v-layout>
      </v-container>
    </v-jumbotron>

    <v-jumbotron
      v-if="state === 'STATE_ROLL_INITIATIVE'"
      color="success"
      dark
    >
      <v-container fill-height>
        <v-layout align-center>
          <v-flex text-xs-center>
            <h3 class="display-3">
              Roll Initiative
            </h3>
          </v-flex>
        </v-layout>
      </v-container>
    </v-jumbotron>

    <v-layout
      v-if="state === 'STATE_IN_COMBAT'"
      row
    >
      <v-flex>
        <v-card>
          <v-list>
            <v-list-tile
              v-for="entity in initiativeOrderedEntities"
              :key="entity.id"
              v-bind:class="{primary: isCurrentId(entity.id)}"
            >
              <v-list-tile-content>
                <v-list-tile-title v-text="entity.name" />
              </v-list-tile-content>
            </v-list-tile>
          </v-list>
        </v-card>
      </v-flex>

      <v-btn
        color="error"
        dark
        large
        @click="nextTurn"
      >
        Next
      </v-btn>
    </v-layout>
  </v-container>
</template>

<script>
import io from 'socket.io-client';
export default {
  name: 'Public',
  data() {
    return {
      entities: [],
      state: false,
      currentTurn: 0,
      socket: io('localhost:80')
    }
  },
  computed: {
    initiativeOrderedEntities() {
      var ordered = this.entities;
      ordered.sort((a, b) => {
        var aInit = parseInt(a.initiative);
        var bInit = parseInt(b.initiative);
        if (aInit > bInit) {
          return -1;
        }

        if (bInit > aInit) {
          return 1;
        }

        // implicit b.initiate == a.initiative
        if (a.dex > b.dex) {
          return -1;
        }

        if (b.dex > a.dex) {
          return 1;
        }

        return 0;
      });

      return ordered;
    },
  },
  mounted() {
    this.socket.on('INITIALISE', (data) => {
      this.entities = data.entities;
      this.state = data.state;
    });

    this.socket.on('ENTITIES_UPDATED', (data) => {
      this.entities = data;
    });

    this.socket.on('STATE_CHANGED', (state) => {
      this.state = state;
    });
  },
  methods: {
    nextTurn() {
      this.currentTurn++;
      if (this.currentTurn >= this.entities.length) {
        this.currentTurn = 0;
      }
      this.socket.emit('NEXT_TURN');
    },
    isCurrentId(id) {
      return this.initiativeOrderedEntities.findIndex(entity => entity.id ==id) == this.currentTurn;
    }
  }
}
</script>

<style>
</style>
