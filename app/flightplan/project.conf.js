/**
 * Project specific settings for flightplan.
 */

var config = {

    //relative web root to this local build
    webRoot: '/dist',

    targets: {

        local:{},

        staging: {
            hosts: {
                host: 'staging.em87.io',
                username: 'evermadeweb',
                privateKey: '',
                passphrase: process.env.EVERMADEWEB_PASSPHRASE,
                agentForward: true,
                agent: process.env.SSH_AUTH_SOCK
            },
            options: {
                buildRoot: '/srv/www/oodi.staging.em87.io', // No trailing slash
                webRoot: '/dist', //relative from build root
                url: 'http://oodi.staging.em87.io', // No trailing slash
                dbPush: true,
                log: true
            }
        },

        production: {
            hosts: {
                host: '94.237.9.125',
                username: 'evermade',
                privateKey: '',
                passphrase: process.env.EVERMADEWEB_PASSPHRASE,
                agentForward: true,
                agent: process.env.SSH_AUTH_SOCK
            },
            options: {
                buildRoot: '/srv/www/www.oodihelsinki.fi', // No trailing slash
                webRoot: '/dist', //relative from build root
                url: 'http://www.oodihelsinki.fi', // No trailing slash
                dbPush: false,
                log: false
            }
        }

    }

};

module.exports = config;
