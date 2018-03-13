pipeline {
    agent any
    stages {
        stage('Stage 1: Download Docker Repo') {
            steps {
                build job: 'ci-concept-docker'
                echo 'Docker repo was Downloaded'
            }
        }
        stage('Stage 2: Build') {
            steps {
                dir ('../ci-concept-docker') {
                  echo 'Starting Docker Containers'
                  sh './develop up -d'
                  echo 'Installing Dependencies'
                  sh './develop composer install'
                  echo 'Running PHPUnit Tests'
                  sh './develop t ./tests'
                  echo 'Destroying Containers'
                  sh './develop down'
                }
            }
        }
        stage('Stage 3: Deploy to Staging') {
            environment {
                /* Staging Server Variables */
                DOCKERFOLDER='/home/ubuntu/ci-concept-docker'
                SSH_PORT=4263
                SSH_USER='ubuntu'
                SSH_IP='172.31.44.218'
                APP_PORT=80
            }
            steps {
                echo 'Available variables'
                sh 'printenv'
                dir ('../ci-concept-docker') {
                  echo 'Copying docker repo to Staging'
                  sh "scp -P ${SSH_PORT} -r . ${SSH_USER}@${SSH_IP}:${env.DOCKERFOLDER}"
                }
                dir ('../ci-concept-script') {
                  echo 'Copying project repo to Staging'
                  sh "scp -P ${SSH_PORT} -r . ${SSH_USER}@${SSH_IP}:/home/ubuntu/ci-concept-script"
                }
                echo 'Starting Docker Containers on Staging'
                sh "ssh -p ${SSH_PORT} -o SendEnv=APP_PORT ${SSH_USER}@${SSH_IP} export APP_PORT=${env.APP_PORT}; echo $APP_PORT"
                sh "ssh -p ${SSH_PORT} ${SSH_USER}@${SSH_IP} docker-compose -f ${env.DOCKERFOLDER}/docker-compose.dev.yml up -d"
                echo 'Installing Dependencies on Staging'
                sh "ssh -p ${SSH_PORT} ${SSH_USER}@${SSH_IP} docker-compose -f ${env.DOCKERFOLDER}/docker-compose.dev.yml exec -T php composer install"
            }
        }
    }
}
