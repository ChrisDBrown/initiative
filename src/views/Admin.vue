<template>
  <v-container>
    <div v-if="state === 'STATE_OUT_OF_COMBAT'">
      <v-form>
        <v-layout row>
          <v-flex md4>
            <v-text-field
              v-model="enemyForm.name"
              label="Enemy Name"
              placeholder="Tiamat"
              required
            />
          </v-flex>

          <v-flex
            md2
            offset-m1
          >
            <v-text-field
              v-model="enemyForm.hp"
              type="number"
              label="Max HP"
              placeholder="100"
              required
            />
          </v-flex>

          <v-flex
            md2
            offset-m1
          >
            <v-text-field
              v-model="enemyForm.dex"
              type="number"
              label="Dex Modifier"
              placeholder="-1"
              required
            />
          </v-flex>

          <v-flex md2>
            <v-text-field
              v-model="enemyForm.count"
              type="number"
              label="How many?"
              required
            />
          </v-flex>

          <v-btn
            color="primary"
            large
            @click="addEnemy"
          >
            Add
          </v-btn>
        </v-layout>
      </v-form>

      <v-flex v-if="entities.filter(e => e.type == 'enemy').length > 0" md5>
        <v-card>
          <v-list
            subheader
            two-line
          >
            <v-list-tile
              v-for="enemy in entities.filter(e => e.type == 'enemy')"
              :key="enemy.id"
            >
              <v-list-tile-content>
                <v-list-tile-title v-text="enemy.name" />
                <v-list-tile-sub-title>{{ enemy.maxHp }} Max HP</v-list-tile-sub-title>
                <v-list-tile-sub-title>{{ enemy.dex }} Dex Modifier</v-list-tile-sub-title>
              </v-list-tile-content>

              <v-list-tile-action>
                <v-btn icon ripple>
                  <v-icon color="grey lighten-1" @click="deleteEnemy(enemy.id)">delete</v-icon>
                </v-btn>
              </v-list-tile-action>
            </v-list-tile>
          </v-list>
        </v-card>
      </v-flex>

      <v-btn
        color="error"
        dark
        large
        @click="changeState('STATE_ROLL_INITIATIVE')"
      >
        Roll Initiative
      </v-btn>
    </div>

    <div v-if="state === 'STATE_ROLL_INITIATIVE'">
      <v-form>
        <v-layout
          v-for="entity in entities"
          :key="entity.id"
        >
          <v-flex md4>
            {{ entity.name }}
          </v-flex>

          <v-flex
            md2
          >
            <v-text-field
              v-model="entity.initiative"
              type="number"
              label="Initiative roll"
              placeholder="10"
              required
            />
          </v-flex>
        </v-layout>
      </v-form>

      <v-btn
        color="error"
        dark
        large
        @click="startFight"
      >
        Start Fight
      </v-btn>
    </div>

    <div v-if="state === 'STATE_ROLL_INITIATIVE'">
      FIGHT
    </div>
  </v-container>
</template>

<script>
import io from 'socket.io-client';
export default {
  name: 'Admin',
  data() {
    return {
      entities: [],
      state: false,
      socket: io('localhost:80'),
      enemyForm: { count: 1}
    }
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
    changeState(state) {
      this.socket.emit('CHANGE_STATE', state);
    },
    addEnemy() {
      if (this.enemyForm.count === 1) {
        this.socket.emit('ADD_ENEMY', {
          name: this.enemyForm.name,
          maxHp: this.enemyForm.hp,
          dex: this.enemyForm.dex
        });
      } else {
        for (var i = 1; i <= this.enemyForm.count; i++) {
          this.socket.emit('ADD_ENEMY', {
            name: `${this.enemyForm.name} ${String.fromCharCode(i + 64)}`,
            maxHp: this.enemyForm.hp,
            dex: this.enemyForm.dex
          });
        }
      }
    },
    deleteEnemy(id) {
      this.socket.emit('DELETE_ENEMY', id);
    },
    startFight() {
      this.socket.emit('START_FIGHT', this.entities);
    }
  }
}
</script>

<style>
</style>
