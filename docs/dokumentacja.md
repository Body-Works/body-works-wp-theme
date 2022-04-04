# Dokumentacja Body Works

Autor: *Konrad Fedorczyk*

Kontakt: *contact[małpa]realhe.ro*

## Szablon

Motyw `body-works` jest potomny do `salient` (ten drugi musi być zainstalowany, żeby z niego skorzystać). Cały kod szablonu, wraz z dokumentacją (m.in. tym plikiem), znajduje się w repozytorium [GitHub - Body-Works/body-works-wp-theme](https://github.com/Body-Works/body-works-wp-theme).

Dla ułatwienia życia przyszłym programistom, proponuję dokonywać zmian właśnie w repozytorum, a dopiero później przerzucać je na serwer produkcyjny.

W pliku readme znajduje się instrukcja budowania assetów.

### Opisy produktów

Opisy produktów wykorzystują kilka predefiniowanych szablonów (w zależności od ilości produktów składowych). Znajdziesz je w folderze `docs/layouts`. 

Style tych szablonów (jak i wszystkie inne dodatkowe style) zostały napisane w metodologii ABEM.

### Grafiki

Do standaryzacji grafik najlepiej używać szablonów, które można znaleźć w folderze `docs/psd-templates`. 

### Ogólnie co jest w tym repozytorium?

- Kod witryny,

- Pliki źródłowe `SCSS` i `JS`,

- Konfiguracja `Grunt` i `npm`,

- Grafiki źródłowe,

- W folderze docs:
  
  - Konfiguracja `ACF`,
  
  - Szablony `PSD` dla grafik na witrynie,
  
  - Layouty i wycinki z treścią (dla szybszej i wygodniejszej edycji).



## Generator przycisków

W repozytorium [GitHub - Body-Works/csv-to-buttons: Generate buttons from CSV](https://github.com/Body-Works/csv-to-buttons) znajduje się generator przycisków. Służy on do szybkiego tworzenia HTML'a z odnośnikami do dokumentacji programistów. W pliku `readme` znajduje się dokumentacja jak z niego korzystać. 

Skompilowaną wersję można znaleźć [tutaj](https://body-works.pl/csv-to-buttons/).

> Aby skorzystać z tego narzędzia należy utworzyć najpierw skoroszyt z URL'ami do dokumentafcji. Takie pliki znajdują się na Google Drive należącym do Body Works. 

### Minifikowanie kodu

`WordPress` ma brzydką tendencję do dodawania własnego HTML'a w miejsce nowych linii itp. Aby tego uniknąć używałem swojego narzędzia pod tym [adresem](https://minifyhtml.realhe.ro/).

## Narzędzie do automatycznego podpisywania zdjęć produktów

W repozytorium [GitHub - Body-Works/body-works-alt-title-fixer: Automatic fix for image titles & alts](https://github.com/Body-Works/body-works-alt-title-fixer) znajduje się narzędzie do masowego podpisywania zdjęć produktów. Żeby z niego korzystać należy przerzucić pliki na serwer za pomocą FTP i poprzez SSH wykonać komendę:

```bash
php74 -f main.php
```

**Uwaga!** Zalecane jest wykonanie kopii zapasowej bazy danych przed tą operacją (jest nieodwracalna).

> Skonfigurowane narzędzie jest już umieszczoneone w folderze root serwera Body Works. 

Więcej info w `readme` repozytorium.

## Konfiguracja Dockera do szybkiego tworzenia kopii serwisu

Ustawienia dla `Dockera` można znaleźć tutaj: [GitHub - Body-Works/docker-conf: Docker configuration for Body Works](https://github.com/Body-Works/docker-conf). 

## Porządek

Jeżeli chcesz ułatwić następnemu programiście życie, to stosuj się do reguł ustalonych dla tej organizacji. Przykładowo kategoryzuj odpowiednio zdjęcia wrzucane do CMS'a i commituj zmiany w repozytorium. 
