#! /bin/bash

THEME_PATH=./app/themes/ongonline
BOOTSTRAP=$THEME_PATH/css/bootstrap.css
BOOTSTRAP_MIN=$THEME_PATH/css/bootstrap.min.css
BOOTSTRAP_LESS=$THEME_PATH/assets/bootstrap-less/bootstrap.less
BOOTSTRAP_RESPONSIVE=$THEME_PATH/css/bootstrap-responsive.css
BOOTSTRAP_RESPONSIVE_MIN=$THEME_PATH/css/bootstrap-responsive.min.css
BOOTSTRAP_RESPONSIVE_LESS=$THEME_PATH/assets/bootstrap-less/responsive.less

BTSW=$THEME_PATH/css/bootswatch.css
BTSW_MIN=$THEME_PATH/css/bootswatch.min.css
BTSW_LESS=$THEME_PATH/assets/ong-less/bootswatch.less


ONG=$THEME_PATH/css/ong.css
ONG_MIN=$THEME_PATH/css/ong.min.css
ONG_LESS=$THEME_PATH/assets/ong-less/ong.less


DATE=`date +%I:%M%p`
CHECK=✔
HR=\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#\#

clear
echo "${HR}"
echo "Building Bootstrap..."
echo "${HR}"
recess --compile ${BOOTSTRAP_LESS} > ${BOOTSTRAP}
recess --compress ${BOOTSTRAP_LESS} > ${BOOTSTRAP_MIN}
recess --compile ${BOOTSTRAP_RESPONSIVE_LESS} > ${BOOTSTRAP_RESPONSIVE}
recess --compress ${BOOTSTRAP_RESPONSIVE_LESS} > ${BOOTSTRAP_RESPONSIVE_MIN}
echo "Compiling and Compressing Bootstrap LESS with Recess... ${CHECK} Done"

echo "${HR}"
echo "Building Bootswatch..."
echo "${HR}"
#recess --compile ${BTSW_LESS} > ${BTSW}
recess --compress ${BTSW} > ${BTSW_MIN}
echo "Compiling and Compressing BOOTSWATCH LESS with Recess... ${CHECK} Done"

echo "${HR}"
echo "Building ONG..."
echo "${HR}"
recess --compile ${ONG_LESS} > ${ONG}
recess --compress ${ONG_LESS} > ${ONG_MIN}
echo "Compiling and Compressing ONG LESS with Recess... ${CHECK} Done"

echo $HR
echo ${CHECK} 'FINALIZADO'
