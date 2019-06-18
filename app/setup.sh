#!/bin/bash 

#load our env vars
source ./env/.env

# spin up the docker stack
echo -e "\n Spinning up the docker stack"
docker-compose up --build -d

# check and remove git repo if dockerpress
repo_url=$(git config --get remote.origin.url)

if [ $repo_url = "git@bitbucket.org:evermade/dockerpress.git" ]; then
	sudo rm -rf ../.git
fi

# composer
echo -e "\nInstalling WP Core and dependencies via Composer"
docker run -it --rm -v $(pwd):/app composer/composer install --no-dev

# install the swiss theme
echo -e "\nFetching Swiss WP theme"
if [ ! -d "src/wp-content/themes/$WP_THEME_NAME" ]; then
	git clone git@github.com:evermade/swiss.git "src/wp-content/themes/$WP_THEME_NAME"
	sudo rm -rf "src/wp-content/themes/$WP_THEME_NAME/.git"
else
	echo -e "\n$WP_THEME_NAME theme exists!"
fi

# fix permission
sudo chown evermade:evermade -R src/wp-content/themes

echo -e "\nModifying permissions for acf-json/"
sudo chmod 777 -R src/wp-content/themes/$WP_THEME_NAME/acf-json

echo -e "\nModifying permissions for uploads/"
sudo chmod 777 -R src/wp-content/uploads

echo -e "\nnpm install"
docker run -it --rm -v $(pwd):/app onefastsnail/development:legacy npm install

# add our blocks
~/em/em.sh everblox add hero hero
~/em/em.sh everblox add columns columns
~/em/em.sh everblox add image image
~/em/em.sh everblox add section section
~/em/em.sh everblox add image-text image-text

echo -e "\nGulp'n"
docker run -it --rm  -v $(pwd):/app onefastsnail/development:legacy npm run build

echo -e "\nSetup Wordpress"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp core install --url="$APP_URL" --title="$APP_TITLE" --admin_user="$WP_ADMIN_NAME" --admin_password="$WP_ADMIN_PASSWORD" --admin_email="$WP_ADMIN_EMAIL" --allow-root

echo -e "\nChanging Wordpress Permalinks"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp rewrite structure '/%postname%/' --allow-root

echo -e "\nActivating ACF plugin"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp plugin activate advanced-custom-fields-pro --allow-root

echo -e "\nActivate theme"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp theme activate $WP_THEME_NAME --allow-root

echo -e "\nMaking EM toolbox page"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp post create --post_type=page --post_title="em" --post_status="publish" --allow-root

echo -e "\nUpdate show page as front page"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp option update show_on_front page --allow-root

echo -e "\nCreate and Update page for home page"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp option update page_on_front $(docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp post create --porcelain --post_type=page --post_title="Home" --post_status="publish" --allow-root) --allow-root

echo -e "\nCreate and Update page for posts"
docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp option update page_for_posts $(docker run --rm -it --env-file $(pwd)/env/.env -v $(pwd):/app --workdir /app/dist --link mysql:mysql onefastsnail/development:legacy wp post create --porcelain --post_type=page --post_title="Blog" --post_status="publish" --allow-root) --allow-root