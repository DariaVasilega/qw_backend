const fragmentsComposingStrategy = new Map([
    ['default', (base, current) => base.slice(-1) === '=' ? `${base}${current}&` : `${base}${current}=`],
    ['view', (base, current) => `${base}${base.slice(-1) === '&' ? '' : '&'}disabled=true`],
    ['edit', (base, current) => base],
    ['p', (base, current) => `${base}${base.slice(-1) === '&' ? '' : '&'}page=${current.split('p').pop()}`],
]);

const composeQueryFromFragments = (crumbs) => crumbs.reduce(
    (accumulator, current) => {
        let currentStrategy = current;

        if (current[0] === 'p') {
            currentStrategy = 'p';
        }

        const compose = fragmentsComposingStrategy.has(currentStrategy)
           ? fragmentsComposingStrategy.get(currentStrategy)
           : fragmentsComposingStrategy.get('default')

        return compose(accumulator, current);
    },
    ''
);

const route = () => {
    const anchor = window.location.hash.substring(1);
    const fragments = anchor.split('-');
    const url = fragments.length > 1
        ? `${window.location.origin}/admin/page/${fragments.shift()}?${composeQueryFromFragments(fragments)}`
        : `${window.location.origin}/admin/page/${fragments[0]}`;

    htmx.ajax('GET', url, '.content');
}

const body = document.querySelector('body');

body.addEventListener('mouseover',() => window.innerDocClick = true);
body.addEventListener('mouseleave',() => window.innerDocClick = false);
window.addEventListener('load', () => route());
window.addEventListener('popstate', () => window.innerDocClick ? void (0) : route());