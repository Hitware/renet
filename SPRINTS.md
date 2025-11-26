# Plan de Sprints - RENET
## Registro Nacional de Embarcaciones y Tripulantes

---

## Información del Proyecto

**Duración de cada Sprint:** 2 semanas
**Total de Sprints:** 8 (16 semanas / 4 meses)
**Metodología:** Scrum/Agile

**Objetivo Principal:** Desarrollar una plataforma de verificación para embarcaciones en Cartagena, especialmente para las 850 motonaves de pasaje de uso comercial.

---

## Sprint 0: Setup y Fundamentos
**Duración:** 2 semanas

### Objetivos:
- Configurar entorno de desarrollo completo
- Establecer arquitectura base de la aplicación
- Crear modelos de datos fundamentales

### Tareas:

#### Backend & Base de Datos
- [ ] Configurar base de datos MySQL (renet)
- [ ] Crear migración para tabla `users` (con roles)
- [ ] Crear migración para tabla `empresas` (empresas de transporte)
- [ ] Crear migración para tabla `embarcaciones` (motonaves)
- [ ] Implementar sistema de roles (público, inspector, empresa, admin)
- [ ] Configurar autenticación con Jetstream/Livewire

#### Frontend
- [ ] Completar diseño de página principal ✅
- [ ] Crear layouts base para dashboard
- [ ] Establecer sistema de componentes Livewire reutilizables

#### Infraestructura
- [ ] Configurar entorno de desarrollo local
- [ ] Establecer estructura de carpetas del proyecto
- [ ] Documentar guías de desarrollo

### Entregables:
- Base de datos estructurada con tablas fundamentales
- Sistema de autenticación funcional con roles
- Layouts base para la aplicación

---

## Sprint 1: Módulo de Verificación - Parte 1
**Duración:** 2 semanas

### Objetivo:
Crear el sistema de registro y gestión básica de embarcaciones

### Tareas:

#### Modelos y Migraciones
- [ ] Crear migración para `documentos_embarcacion`
  - Matrícula
  - Certificados de seguridad
  - Pólizas de seguro
  - Fecha de vencimiento
- [ ] Crear modelo `Embarcacion` con relaciones
- [ ] Crear modelo `DocumentoEmbarcacion`

#### Funcionalidades
- [ ] CRUD de embarcaciones (crear, leer, actualizar, eliminar)
- [ ] Sistema de carga de documentos (PDF, imágenes)
- [ ] Validación de campos obligatorios
- [ ] Verificación automática de fechas de vencimiento

#### UI/UX
- [ ] Dashboard para empresas de transporte
- [ ] Formulario de registro de embarcaciones
- [ ] Lista de embarcaciones registradas
- [ ] Vista detalle de embarcación individual

### Entregables:
- Empresas pueden registrar sus embarcaciones
- Sistema de gestión documental básico
- Dashboard operativo para empresas

---

## Sprint 2: Módulo de Verificación - Parte 2 (Sistema QR)
**Duración:** 2 semanas

### Objetivo:
Implementar el sistema de códigos QR y verificación instantánea

### Tareas:

#### Sistema QR
- [ ] Integrar librería de generación de QR (SimpleSoftwareIO/simple-qrcode)
- [ ] Crear endpoint para generar QR único por embarcación
- [ ] Diseñar tarjeta de propiedad física con QR (PDF descargable)
- [ ] Crear sistema de códigos únicos encriptados

#### Verificación Pública
- [ ] Crear página pública de escaneo/consulta
- [ ] Implementar lógica de estado (verde/rojo)
- [ ] Mostrar información relevante según estado
- [ ] Listar razones si embarcación no disponible

#### Lógica de Negocio
- [ ] Algoritmo de verificación de documentos vigentes
- [ ] Sistema de alertas por vencimientos próximos (30 días)
- [ ] Registro de consultas (auditoría)

#### UI/UX
- [ ] Página de escaneo QR responsive
- [ ] Pantalla verde (embarcación disponible)
- [ ] Pantalla roja (embarcación no disponible)
- [ ] Vista detallada de documentación

### Entregables:
- Sistema QR funcional
- Verificación pública operativa
- Tarjeta de propiedad con QR descargable

---

## Sprint 3: Módulo de Verificación - Parte 3 (Panel de Inspectores)
**Duración:** 2 semanas

### Objetivo:
Crear panel especial para autoridades marítimas (inspectores DIMAR)

### Tareas:

#### Panel de Inspectores
- [ ] Dashboard específico para inspectores
- [ ] Búsqueda avanzada de embarcaciones
- [ ] Filtros por estado, empresa, tipo de documento
- [ ] Historial de verificaciones

#### Funcionalidades Avanzadas
- [ ] Sistema de reportes de inspección
- [ ] Notas y observaciones sobre embarcaciones
- [ ] Alertas de irregularidades
- [ ] Exportación de reportes (PDF, Excel)

#### Estadísticas
- [ ] Dashboard de estadísticas generales
- [ ] Embarcaciones por estado
- [ ] Empresas con más irregularidades
- [ ] Documentos próximos a vencer

#### Notificaciones
- [ ] Sistema de notificaciones en tiempo real
- [ ] Alertas por email para vencimientos
- [ ] Notificaciones push (opcional)

### Entregables:
- Panel completo para inspectores
- Sistema de reportes operativo
- Dashboard de estadísticas

---

## Sprint 4: Módulo de Pilotos - Parte 1
**Duración:** 2 semanas

### Objetivo:
Crear base de datos y sistema de registro para pilotos y capitanes

### Tareas:

#### Modelos y Migraciones
- [ ] Crear migración para tabla `pilotos`
  - Datos personales
  - Licencia de navegación
  - Experiencia laboral
  - Foto de perfil
- [ ] Crear migración para `certificaciones_piloto`
- [ ] Crear migración para `historial_navegacion`

#### Funcionalidades
- [ ] CRUD de pilotos
- [ ] Registro de licencias con validación
- [ ] Sistema de carga de documentos
- [ ] Historial de embarcaciones operadas

#### Hoja de Vida Estandarizada
- [ ] Plantilla estandarizada de CV
- [ ] Generación automática de hoja de vida (PDF)
- [ ] Campos obligatorios y opcionales
- [ ] Validación de información

#### UI/UX
- [ ] Formulario de registro de pilotos
- [ ] Perfil público de piloto
- [ ] Lista de certificaciones activas
- [ ] Historial de navegación

### Entregables:
- Sistema de registro de pilotos operativo
- Base de datos de pilotos funcional
- Generación de hojas de vida estandarizadas

---

## Sprint 5: Módulo de Pilotos - Parte 2 (Credenciales QR)
**Duración:** 2 semanas

### Objetivo:
Implementar credenciales digitales con QR para pilotos

### Tareas:

#### Credenciales con QR
- [ ] Diseño de credencial digital
- [ ] Generación de QR único por piloto
- [ ] Credencial descargable (PDF)
- [ ] Versión imprimible

#### Verificación de Pilotos
- [ ] Página pública de verificación de credenciales
- [ ] Consulta de información básica del piloto
- [ ] Validación de licencias vigentes
- [ ] Historial de certificaciones

#### Búsqueda y Consulta
- [ ] Sistema de búsqueda de pilotos disponibles
- [ ] Filtros por tipo de licencia
- [ ] Filtros por experiencia
- [ ] Contacto con pilotos (opcional)

#### Integración con Embarcaciones
- [ ] Asignar piloto a embarcación
- [ ] Registro de tripulación actual
- [ ] Historial de tripulaciones

### Entregables:
- Credenciales digitales con QR
- Sistema de verificación de pilotos
- Integración piloto-embarcación

---

## Sprint 6: Módulo de Empresas - Parte 1
**Duración:** 2 semanas

### Objetivo:
Crear sistema de gestión para empresas de transporte marítimo

### Tareas:

#### Gestión de Empresas
- [ ] Perfil completo de empresa
- [ ] Gestión de flota de embarcaciones
- [ ] Gestión de personal (pilotos)
- [ ] Documentación legal de la empresa

#### Programación de Mantenimientos
- [ ] Crear migración para `mantenimientos`
- [ ] Sistema de programación de mantenimientos
- [ ] Calendario de mantenimientos
- [ ] Alertas de mantenimientos próximos
- [ ] Registro de mantenimientos realizados

#### Tipos de Mantenimiento
- [ ] Mantenimiento preventivo
- [ ] Mantenimiento correctivo
- [ ] Inspecciones técnicas
- [ ] Certificaciones periódicas

#### UI/UX
- [ ] Dashboard de empresa
- [ ] Calendario visual de mantenimientos
- [ ] Formulario de programación
- [ ] Lista de mantenimientos históricos

### Entregables:
- Sistema de gestión de mantenimientos
- Calendario de programación
- Dashboard empresarial completo

---

## Sprint 7: Módulo de Empresas - Parte 2 (Auditorías)
**Duración:** 2 semanas

### Objetivo:
Implementar sistema de auditorías y cumplimiento normativo

### Tareas:

#### Sistema de Auditorías
- [ ] Crear migración para `auditorias`
- [ ] Tipos de auditoría (seguridad, operativa, administrativa)
- [ ] Checklist estandarizado por tipo
- [ ] Registro fotográfico de auditorías
- [ ] Firma digital de inspectores

#### Cumplimiento Normativo
- [ ] Base de datos de normativas DIMAR
- [ ] Verificación automática de cumplimiento
- [ ] Alertas de incumplimientos
- [ ] Plan de acción correctiva

#### Reportes y Documentación
- [ ] Generación de reportes de auditoría (PDF)
- [ ] Historial de auditorías por embarcación
- [ ] Estadísticas de cumplimiento
- [ ] Dashboard de riesgos

#### Seguimiento
- [ ] Sistema de seguimiento de acciones correctivas
- [ ] Estados: pendiente, en proceso, completado
- [ ] Evidencias de corrección
- [ ] Re-auditorías

### Entregables:
- Sistema de auditorías operativo
- Reportes automatizados
- Panel de cumplimiento normativo

---

## Sprint 8: Testing, Optimización y Deployment
**Duración:** 2 semanas

### Objetivo:
Garantizar calidad, optimizar rendimiento y preparar deployment

### Tareas:

#### Testing
- [ ] Testing unitario de funcionalidades críticas
- [ ] Testing de integración
- [ ] Testing de UI/UX
- [ ] Testing de seguridad
- [ ] Testing de carga (850 embarcaciones)

#### Optimización
- [ ] Optimización de consultas a base de datos
- [ ] Implementar caching (Redis)
- [ ] Optimización de imágenes y documentos
- [ ] Lazy loading de componentes
- [ ] Minificación de assets

#### Seguridad
- [ ] Auditoría de seguridad
- [ ] Protección contra inyección SQL
- [ ] Protección XSS y CSRF
- [ ] Encriptación de datos sensibles
- [ ] Backup automático de base de datos

#### Deployment
- [ ] Configurar servidor de producción
- [ ] Setup de dominio y SSL
- [ ] Migración de base de datos
- [ ] Configuración de emails (SMTP)
- [ ] Monitoreo y logs

#### Documentación
- [ ] Manual de usuario (público)
- [ ] Manual de usuario (inspectores)
- [ ] Manual de usuario (empresas)
- [ ] Documentación técnica
- [ ] Videos tutoriales

### Entregables:
- Aplicación completamente testeada
- Plataforma optimizada
- Sistema en producción
- Documentación completa

---

## Roles y Responsabilidades

### Product Owner
- Priorización de features
- Aprobación de entregables
- Comunicación con stakeholders

### Scrum Master
- Facilitación de ceremonias
- Remoción de impedimentos
- Seguimiento de métricas

### Equipo de Desarrollo
- 1 Backend Developer (Laravel/PHP)
- 1 Frontend Developer (Livewire/Alpine.js)
- 1 UI/UX Designer
- 1 QA Tester

---

## Ceremonias Scrum

### Sprint Planning (Inicio de cada sprint)
- Duración: 2 horas
- Selección de historias de usuario
- Estimación de esfuerzo
- Definición de metas del sprint

### Daily Standup (Diario)
- Duración: 15 minutos
- ¿Qué hice ayer?
- ¿Qué haré hoy?
- ¿Hay impedimentos?

### Sprint Review (Fin de sprint)
- Duración: 1 hora
- Demo de funcionalidades completadas
- Feedback de stakeholders
- Ajustes al backlog

### Sprint Retrospective (Fin de sprint)
- Duración: 1 hora
- ¿Qué salió bien?
- ¿Qué se puede mejorar?
- Plan de acción para siguiente sprint

---

## Métricas de Seguimiento

### Velocidad del Equipo
- Story points completados por sprint
- Burn-down chart
- Burn-up chart

### Calidad
- Bugs reportados vs resueltos
- Cobertura de tests
- Deuda técnica

### Satisfacción del Cliente
- Feedback de demos
- Encuestas de usuarios
- Net Promoter Score (NPS)

---

## Riesgos y Mitigación

### Riesgo: Cambios en normativas DIMAR
**Mitigación:** Mantener comunicación constante con autoridades, diseño flexible

### Riesgo: Resistencia al cambio de empresas
**Mitigación:** Capacitación continua, soporte técnico, incentivos

### Riesgo: Problemas técnicos con QR
**Mitigación:** Testing exhaustivo, plan B manual, soporte técnico

### Riesgo: Baja adopción inicial
**Mitigación:** Marketing, demos, casos de éxito, facilidad de uso

---

## Criterios de Aceptación Generales

### Funcionalidad
- ✅ Cumple con los requerimientos especificados
- ✅ Sin bugs críticos
- ✅ Responsive en móvil y desktop

### Usabilidad
- ✅ Interfaz intuitiva
- ✅ Tiempos de carga < 3 segundos
- ✅ Navegación clara

### Seguridad
- ✅ Datos encriptados
- ✅ Autenticación segura
- ✅ Roles y permisos correctos

### Documentación
- ✅ Código documentado
- ✅ Manual de usuario actualizado
- ✅ Tests incluidos

---

## Backlog Priorizado

### Alta Prioridad (MVP)
1. Sistema de registro de embarcaciones
2. Generación y verificación de QR
3. Panel público de consulta
4. Dashboard de empresas

### Media Prioridad
1. Base de datos de pilotos
2. Credenciales con QR
3. Panel de inspectores
4. Sistema de notificaciones

### Baja Prioridad
1. Estadísticas avanzadas
2. Reportes personalizados
3. Integración con APIs externas
4. App móvil nativa

---

## Plan de Capacitación

### Semana 1-2 (Post-deployment)
- Capacitación a autoridades DIMAR
- Capacitación a empresas de transporte
- Webinars para público general

### Semana 3-4
- Soporte técnico intensivo
- Resolución de dudas
- Ajustes basados en feedback

### Mensual
- Actualizaciones y nuevas funcionalidades
- Revisión de métricas
- Mejoras continuas

---

## Notas Adicionales

- Cada sprint incluye buffer del 20% para bugs inesperados
- Las ceremonias son flexibles según disponibilidad del equipo
- El plan puede ajustarse según feedback y prioridades
- Se recomienda usar herramientas como Jira, Trello o Linear para seguimiento

---

**Última actualización:** {{ date('Y-m-d') }}
**Versión:** 1.0
**Estado:** Pendiente de aprobación
