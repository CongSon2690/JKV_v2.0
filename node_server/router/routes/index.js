const express = require('express')
const { app } = require('../../server/express')
const test = require('./test')
const machine = require('./machine')
const monitor = require('./monitor')
const service = require('./service')
const client = require('./client')
const shift = require('./shift')
const runtime = require('./runtime')
const productionLog = require('./productionLog')

app.use('/public/js', express.static(`${process.cwd()}/public/js`))
app.use('/api/machine', machine)
app.use('/api/shift', shift)
app.use('/api/runtime', runtime)
app.use('/api/production-log', productionLog)
app.use('/monitor', monitor)
app.use('/service', service)
app.use('/client', client)
app.use('/test', test)