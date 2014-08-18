package com.etb_lab.my_textbooks.utils.message;

import com.etb_lab.my_textbooks.model.LessonPlan;

import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.map.ObjectMapper;
import org.codehaus.jackson.type.TypeReference;

import java.io.IOException;

/**
 * Class handle JSON conversion of command
 */
public class CommandHandler {

    private static final String COMMAND = "command";

    /**
     * JavaScript function which sends to devices
     */
    public static final String PLAY_VIDEO = "";
    public static final String STOP_VIDEO = "";
    public static final String CHANGE_SLIDE = "";
    public static final String START_SLIDESHOW = "";
    public static final String ACTIVATE_MAP_LAYERS = "";

    /**
     * Gson object. It needs for JSON transformation
     */
    private static ObjectMapper mapper = new ObjectMapper();

    /**
     * Available types of devices
     */
    public enum DeviceType{
        INFORMATION_BOARD,
        TEACHER_TABLET,
        PUPIL_TABLET,
    }

    /**
     * Available control commands
     */
    public enum Command{
        //lesson commands
        CONTENT_COMMAND,
        START_LESSON,
        FINISH_LESSON,
        STAGE,

        // test commands
        ADD_TIME,
        START_TEST,
        FINISH_TEST,
        SET_VARIANT,
        SHOW_TEST_PROGRESS,
        SELF_DISTRIBUTION_VARIANTS,

        ANSWER,
        PUPIL_VARIANT
    }

    /**
     * Send JSON string from given device type, command and content and send it to group chat
     * @param deviceType target device for command
     * @param command control command
     * @param content command content
     */
    private static void createAndSendCommand(DeviceType deviceType, Command command, Object content){
        CommandMessage<Object> message = new CommandMessage<Object>();
        message.setDeviceType(deviceType);
        message.setCommand(command);
        message.setData(content);
        try {
            String stringMessage = mapper.writeValueAsString(message);
        } catch (IOException e) {
            e.printStackTrace();
        }
        //todo add functional for sendind json command in group chat
    }

//////////////////_________LESSON_COMMANDS______________/////////////////////////
    /**
     * Send JSON string with start lesson command for selected device type
     * @param deviceType target device for command
     */
    public static void sendStartLessonCommand(DeviceType deviceType){
        createAndSendCommand(deviceType, Command.START_LESSON, null);
    }

    /**
     * Send JSON string with finish lesson command for selected device type
     * @param deviceType target device for command
     */
    public static void sendFinishLessonCommand(DeviceType deviceType){
        createAndSendCommand(deviceType, Command.FINISH_LESSON, null);
    }

    /**
     * Send JSON string with next stage command for selected device type
     * @param id id of lesson stage
     * @param deviceType target device for command
     */
    public static void sendNextStageCommand(Integer id, DeviceType deviceType){
        createAndSendCommand(deviceType, Command.STAGE, id);
    }

    /**
     * Send JSON string with command to control content on target device
     * @param action JavaScript function wic will be run on target device
     * @param deviceType target device for command
     */
    public static void sendContentActionCommand (String action, DeviceType deviceType){
        createAndSendCommand(deviceType, Command.CONTENT_COMMAND, action);
    }


//////////////////_________TEST_COMMANDS______________/////////////////////////
    /**
     * Send JSON string with start test command for selected device type
     * @param deviceType target device for command
     */
    public static void sendStartTestCommand(DeviceType deviceType){
        createAndSendCommand(deviceType, Command.START_TEST, null);
    }

    /**
     * Send JSON string with finish test command for selected device type
     * @param deviceType target device for command
     */
    public static void sendFinishTestCommand(DeviceType deviceType){
        createAndSendCommand(deviceType, Command.FINISH_TEST, null);
    }


    /**
     * Send JSON string with additional test time
     * @param time time to add to test time
     * @param deviceType target device for command
     */
    public static void sendAddTimeCommand(Long time, DeviceType deviceType){
        createAndSendCommand(deviceType, Command.ADD_TIME, time);
    }

    /**
     * Send JSON string with content for information board with test progress
     * @param content content to display on information board
     * @param deviceType target device for command
     */
    public static void sendDisplayTestCommand(String content, DeviceType deviceType){
        createAndSendCommand(deviceType, Command.SHOW_TEST_PROGRESS, content);
    }

    /**
     * Send JSON string with pupil id and variant id
     * @param variant object with pupil id and variant id
     * @param deviceType target device for command
     */
    public static void sendSetVariantCommand(PupilVariant variant, DeviceType deviceType){
        createAndSendCommand(deviceType, Command.SET_VARIANT, variant);
    }

    /**
     * Send JSON string with command for starting self-distribution by variants command
     * @param deviceType target device for command
     */
    public static void sendSelfDistributionVariantsCommand(DeviceType deviceType){
        createAndSendCommand(deviceType, Command.SELF_DISTRIBUTION_VARIANTS, null);
    }

    /**
     * Send JSON string with answer on test question
     * @param answer answer object
     */
    public static void sendAnswerCommand(TestAnswer answer){
        createAndSendCommand(DeviceType.TEACHER_TABLET, Command.ANSWER, answer);
    }

    /**
     * Send JSON string with variant which choose pupil
     * @param variant answer object
     */
    public static void sendPupilVariantCommand(Integer variant){
        createAndSendCommand(DeviceType.TEACHER_TABLET, Command.PUPIL_VARIANT, variant);
    }

    /**
     * Tries to convert JSON string to parametrized CommandMessage object
     * @param json JSON string to parse
     * @return object representation of given JSON string
     */
    public static CommandMessage getMessageFromJson(String json) throws IOException {
        JsonNode jsonObject = mapper.readTree(json);
        String command = jsonObject.get(COMMAND).asText();
        CommandMessage message;

        //start/finish lesson/test/self-distribution of variants command
        if(Command.START_LESSON.toString().equals(command)
                || Command.FINISH_LESSON.toString().equals(command)
                || Command.START_TEST.toString().equals(command)
                || Command.FINISH_TEST.toString().equals(command)
                || Command.SELF_DISTRIBUTION_VARIANTS.toString().equals(command)){
            message = mapper.readValue(jsonObject, CommandMessage.class);


        }else{
            TypeReference contentType= null;
            //content control command and display test command
            if (Command.CONTENT_COMMAND.toString().equals(command)
                    || Command.SHOW_TEST_PROGRESS.toString().equals(command)){
                contentType = new TypeReference<CommandMessage<String>>() {};

            //change lesson stage command
            }else if(Command.STAGE.toString().equals(command)
                    || Command.PUPIL_VARIANT.toString().equals(command)){
                contentType = new TypeReference<CommandMessage<Integer>>() {};

            //add time command
            }else if (Command.ADD_TIME.toString().equals(command)){
                contentType = new TypeReference<CommandMessage<Long>>() {};

            //set test variant command
            }else if (Command.SET_VARIANT.toString().equals(command)){
                contentType = new TypeReference<CommandMessage<PupilVariant>>() {};

            //test answer
            }else if (Command.ANSWER.toString().equals(command)){
                contentType = new TypeReference<CommandMessage<TestAnswer>>() {};
            }

            if(contentType == null){
                message = null;
            }else {
                message = mapper.readValue(jsonObject, contentType);
            }
        }
        return message;
    }

    public static String saveLessonPlan(LessonPlan lessonPlan) throws IOException {
        return mapper.writeValueAsString(lessonPlan);
    }

    public static LessonPlan readLessonPlan(String json) throws IOException {
        return mapper.readValue(json, LessonPlan.class);
    }
}
