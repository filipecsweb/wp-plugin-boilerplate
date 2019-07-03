import {dest, parallel, series, src, watch} from 'gulp';
import sass from 'gulp-sass';
import cleancss from 'gulp-clean-css';
import postcss from 'gulp-postcss';
import autoprefixer from 'autoprefixer';
import imagemin from 'gulp-imagemin';
import webpack from 'webpack-stream';
import named from 'vinyl-named';
import sourcemaps from 'gulp-sourcemaps';

export const styles_public = () => {
    return src(['assets/src/scss/public/bundle-public.scss'])
    // .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer]))
        .pipe(cleancss({compatibility: 'ie8'}))
        // .pipe(sourcemaps.write())
        .pipe(dest('assets/dist/css'))
};

export const styles_admin = () => {
    return src(['assets/src/scss/admin/bundle-admin.scss'])
    // .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss([autoprefixer]))
        .pipe(cleancss({compatibility: 'ie8'}))
        // .pipe(sourcemaps.write())
        .pipe(dest('assets/dist/css'))
};

export const scripts_public = () => {
    return src(['assets/src/js/public/bundle-public.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            mode: 'production',
            devtool: false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            }
        }))
        .pipe(dest('assets/dist/js'));
};

export const scripts_admin = () => {
    return src(['assets/src/js/admin/bundle-admin.js'])
        .pipe(named())
        .pipe(webpack({
            module: {
                rules: [
                    {
                        test: /\.js$/,
                        use: {
                            loader: 'babel-loader',
                            options: {
                                presets: ['@babel/preset-env']
                            }
                        }
                    }
                ]
            },
            mode: 'production',
            devtool: false,
            output: {
                filename: '[name].js'
            },
            externals: {
                jquery: 'jQuery'
            }
        }))
        .pipe(dest('assets/dist/js'));
};

export const images = () => {
    return src('assets/src/image/**/*.{jpg,jpeg,png,svg,gif}')
        .pipe(imagemin())
        .pipe(dest('assets/dist/image'));
};

export const copy = () => {
    return src(['assets/src/**/*', '!assets/src/{image,js,scss}', '!assets/src/{image,js,scss}/**/*'])
        .pipe(dest('assets/dist'));
};

export const w = () => {
    watch('assets/src/scss/public/**/*.scss', styles_public);
    watch('assets/src/scss/admin/**/*.scss', styles_admin);
    watch('assets/src/js/public/**/*.js', scripts_public);
    watch('assets/src/js/admin/**/*.js', scripts_admin);
    watch('assets/src/image/**/*.{jpg,jpeg,png,svg,gif}', images);
    watch(['assets/src/**/*', '!assets/src/{image,js,scss}', '!assets/src/{image,js,scss}/**/*'], copy);
};

export const build = series(styles_public, styles_admin, scripts_public, scripts_admin, images, copy);
