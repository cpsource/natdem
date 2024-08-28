Let's play with openai a bit.

1. enter your python venv as follows:

```
  source openai/bin/activate
```

2. Install Parsedown and Parsedown-extra. Download repository.

```
   git clone https://github.com/erusev/parsedown.git
   git clone https://github.com/erusev/parsedown-extra.git
```

3. Get a project key from openai.
4. Edit curly.sh with that key. The one here is bogus.
5. query ChatGPT4:

```
  /curly.sh > content.md
```

6. Now test. For JS, browse at inner-content1.html. For PHP, point at openai-test.php.


