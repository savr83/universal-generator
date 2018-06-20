# universal-generator
String lists generator used to produce mass strings for XML, and other formats

## 2do
### backend
- уникальные поля в выборке источников наборов данных (- лишние переборы)
- ~~php getData() перепесиать с использованием magic method, iterators?~~ реализовано через IteratorAggragate
- добавить пред и пост обработку данных, единообразно для входящих и исходящих данных
- валиадация входящих и исходящих данных
- переработать метод генерации даннх в DST.
- ВАЖНО! cartesian_product работает как итератор, не использовать массив, включить очереди laravel
- нагуглить особенности импользования Rule required|...
- добавить в следующую миграцию fields.validation_rule + rules.processing_logic ->nullable()
- `AttributeName.php` нужен? анах?

### frontend
- ~~frontent UI + Redux (store, reducers, actions)~~ добавлено на базовом уровне
- построить элементы UI
- вложенные роуты и компоненты
- задать специализированные редюсеры по компонентам
- добавить экшны по компонентам

### etc
- ебошить коменты ВЕЗДЕ!!!



---

КОНЕЦ!
