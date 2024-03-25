## Local setup

#### Prerequisites
 - Docker
 - Docker compose

#### Clone
```
git clone https://github.com/mehedi8gb/pws.git
```
#### Open directory
```
cd pws
```
#### Build
```
./bin/deploy_dev.sh
```

#### Access the dev site
```
http://localhost:8000
```

## Deployment
### Staging
All branches(including master) are automatically deployed to staging

### SSH into staging
```
ssh -i ~/.ssh/staging-deploy root@staging.backoffice2.daynightprint.co.uk
cd /home/app/pws/
docker compose exec -it app bash
```
~/.ssh/staging-deploy should be the path to your private key which has been added to the staging box


### Production
Only the master branch can be deployed to production after a PR is merged
Deployment to production needs to be manually approved in the pipeline https://app.circleci.com/pipelines/github/Daynightprint/new-backoffice?branch=master

