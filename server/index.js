var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);

server.listen(80);

const players = [
  {
    id: 0,
    name: 'Imriel',
    type: 'Player',
    dex: 2,
  },
  {
    id: 1,
    name: 'Ghuan',
    type: 'Player',
    dex: 1,
  },
  {
    id: 2,
    name: 'Brienne',
    type: 'Player',
    dex: 5,
  },
  {
    id: 3,
    name: 'Kaiser',
    type: 'Player',
    dex: 1,
  },
  {
    id: 4,
    name: 'Seth',
    type: 'Player',
    dex: 1,
  },
  {
    id: 5,
    name: 'Tarin',
    type: 'Player',
    dex: 2,
  },
  {
    id: 6,
    name: 'Boggy',
    type: 'Player',
    dex: 1,
  }
];

var baseData = {
  entities: players,
  state: 'STATE_OUT_OF_COMBAT'
};

var currentData = baseData;
var nextId = 7;

io.on('connection', function(socket) {
  io.emit('INITIALISE', currentData);

  socket.on('ADD_ENEMY', (data) => {
    data.id = nextId;
    nextId++;
    data.currentHp = data.maxHp;
    data.type = 'enemy';
    currentData.entities.push(data);
    io.emit('ENTITIES_UPDATED', currentData.entities);
  })

  socket.on('DELETE_ENEMY', (id) => {
    currentData.entities = currentData.entities.filter(entity => entity.id !== id);
    io.emit('ENTITIES_UPDATED', currentData.entities);
  });

  socket.on('START_FIGHT', (entities) => {
    currentData.entities = entities;
    io.emit('ENTITIES_UPDATED', currentData.entities);
    currentData.state = 'STATE_IN_COMBAT';
    io.emit('STATE_CHANGED', currentData.state);
  });

  socket.on('CHANGE_STATE', (state) => {
    currentData.state = state;
    io.emit('STATE_CHANGED', currentData.state);
  })

  socket.on('NEXT_TURN', () => {
    console.log('got next turn message');
  });
});
