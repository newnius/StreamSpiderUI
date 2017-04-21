$(function(){
	switch(page_type){
		case "counts":
			load_counts();
			register_events_count();
			break;
		case "queue":
			load_queue();
			register_events_queue();
			break;
		case "stats":
			load_stats();
			register_events_stats();
			break;
		case "patterns":
			load_patterns();
			register_events_pattern();
			register_events_config();
			break;
		default:
			;
	}
});
